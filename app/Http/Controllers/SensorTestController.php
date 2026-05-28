<?php

namespace App\Http\Controllers;

use App\Models\FoodCategory;
use App\Models\SensorDevice;
use App\Models\SensorReading;
use App\Models\ContaminationLog;
use Illuminate\Http\Request;

class SensorTestController extends Controller
{
    public function index()
    {
        $categories = FoodCategory::where('is_active', true)->get();
        $devices = SensorDevice::where('status', 'active')->get();
        $recentReadings = SensorReading::with(['foodCategory', 'sensorDevice'])
            ->latest('read_at')
            ->take(10)
            ->get();

        return view('admin.testing.index', compact('categories', 'devices', 'recentReadings'));
    }

    public function storeReading(Request $request)
    {
        $request->validate([
            'sample_name' => 'nullable|string|max:255',
            'food_category_id' => 'nullable|exists:food_categories,id',
            'temperature' => 'nullable|numeric',
            'humidity' => 'nullable|numeric',
            'gas_level' => 'nullable|numeric',
            'ph_level' => 'nullable|numeric',
            'safety_status' => 'nullable|string|in:aman,waspada,bahaya',
        ]);

        // Determine safety status based on request or thresholds
        $safetyStatus = $request->safety_status;
        if (!$safetyStatus) {
            $safetyStatus = $this->analyzeSafety(
                $request->temperature,
                $request->humidity,
                $request->gas_level,
                $request->ph_level
            );
        }

        $isAnomaly = $safetyStatus !== 'aman';

        $reading = SensorReading::create([
            'sensor_device_id' => $request->sensor_device_id,
            'food_category_id' => $request->food_category_id,
            'sample_name' => $request->sample_name,
            'temperature' => $request->temperature,
            'humidity' => $request->humidity,
            'gas_level' => $request->gas_level,
            'ph_level' => $request->ph_level,
            'is_anomaly' => $isAnomaly,
            'safety_status' => $safetyStatus,
            'notes' => $request->notes,
            'read_at' => now(),
        ]);

        // If anomaly detected, create contamination log
        if ($isAnomaly) {
            $type = $this->detectContaminationType($request->temperature, $request->gas_level, $request->ph_level);
            ContaminationLog::create([
                'sensor_reading_id' => $reading->id,
                'sensor_device_id' => $request->sensor_device_id,
                'food_category_id' => $request->food_category_id,
                'type' => $type,
                'severity' => $safetyStatus === 'bahaya' ? 'kritis' : 'sedang',
                'description' => "Anomali terdeteksi pada sampel: {$request->sample_name}. Suhu: {$request->temperature}°C, Gas: {$request->gas_level} ppm, pH: {$request->ph_level}",
                'status' => 'terdeteksi',
                'detected_at' => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'reading' => $reading->load(['foodCategory', 'sensorDevice']),
            'safety_status' => $safetyStatus,
            'is_anomaly' => $isAnomaly,
            'message' => $isAnomaly
                ? '⚠️ Anomali terdeteksi! Sampel makanan menunjukkan indikasi kontaminasi.'
                : '✅ Sampel makanan dalam kondisi aman.',
        ]);
    }

    private function analyzeSafety($temperature, $humidity, $gasLevel, $phLevel): string
    {
        $dangerCount = 0;
        $warningCount = 0;

        // Temperature analysis (food storage should be < 5°C or > 60°C for hot food)
        // Adjusted to prevent false alarms in typical room temperatures (25-32°C)
        if ($temperature !== null) {
            if ($temperature > 40 || $temperature < -5) {
                $dangerCount++;
            } elseif ($temperature > 35 || $temperature < 0) {
                $warningCount++;
            }
        }

        // Humidity analysis (ideal: 30-70%)
        if ($humidity !== null) {
            if ($humidity > 85 || $humidity < 10) {
                $dangerCount++;
            } elseif ($humidity > 75 || $humidity < 20) {
                $warningCount++;
            }
        }

        // Gas level analysis (MQ sensor - max value from ESP32 is 60)
        // Adjusted to match Arduino code exactly (>= 20 Bahaya, >= 10 Terkontaminasi)
        if ($gasLevel !== null) {
            if ($gasLevel >= 20) {
                $dangerCount++;
            } elseif ($gasLevel >= 10) {
                $warningCount++;
            }
        }

        // pH analysis (ideal food pH: 4.0-7.0)
        if ($phLevel !== null) {
            if ($phLevel > 9 || $phLevel < 2) {
                $dangerCount++;
            } elseif ($phLevel > 7.5 || $phLevel < 3.5) {
                $warningCount++;
            }
        }

        if ($dangerCount >= 1) return 'bahaya';
        if ($warningCount >= 2) return 'waspada';
        if ($warningCount >= 1) return 'waspada';

        return 'aman';
    }

    private function detectContaminationType($temperature, $gasLevel, $phLevel): string
    {
        if ($gasLevel !== null && $gasLevel >= 20) {
            return 'Dekomposisi Gas Tinggi';
        }
        if ($temperature !== null && $temperature > 40) {
            return 'Anomali Suhu Tinggi';
        }
        if ($phLevel !== null && ($phLevel > 9 || $phLevel < 2)) {
            return 'Anomali pH Ekstrem';
        }
        return 'Anomali Multi-Sensor';
    }
}
