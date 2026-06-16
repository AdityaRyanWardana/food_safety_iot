<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\FoodCategory;
use App\Models\SensorDevice;
use App\Models\SensorReading;
use App\Models\ContaminationLog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Default User
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
            ]
        );

        // 2. Seed Food Categories
        $categories = [
            [
                'name' => 'Daging & Olahan',
                'description' => 'Daging sapi, ayam, dan produk olahan daging mentah.',
                'icon' => 'fa-solid fa-drumstick-bite',
            ],
            [
                'name' => 'Sayur & Buah',
                'description' => 'Sayuran segar, buah-buahan, dan bahan segar organik.',
                'icon' => 'fa-solid fa-carrot',
            ],
            [
                'name' => 'Makanan Siap Saji',
                'description' => 'Makanan matang, olahan pasta, hidangan saji cepat.',
                'icon' => 'fa-solid fa-burger',
            ],
        ];

        $categoryModels = [];
        foreach ($categories as $cat) {
            $categoryModels[] = FoodCategory::updateOrCreate(['name' => $cat['name']], $cat);
        }

        // 3. Seed Sensor Devices
        $devices = [
            [
                'device_code' => 'SENS-DG-01',
                'name' => 'Sensor Ruang Daging',
                'type' => 'multi',
                'location' => 'Gudang Penyimpanan Daging A',
                'status' => 'active',
            ],
            [
                'device_code' => 'SENS-SY-02',
                'name' => 'Sensor Rak Sayur',
                'type' => 'multi',
                'location' => 'Chiller Sayuran B',
                'status' => 'active',
            ],
            [
                'device_code' => 'SENS-MS-03',
                'name' => 'Sensor Counter Saji',
                'type' => 'multi',
                'location' => 'Area Saji Hangat C',
                'status' => 'active',
            ],
            [
                'device_code' => 'ESP32-XXSR-69',
                'name' => 'ESP32 xxsr69',
                'type' => 'multi',
                'location' => 'Laboratorium Utama',
                'status' => 'active',
            ],
            [
                'device_code' => 'SENS-OFF-04',
                'name' => 'Sensor Cadangan',
                'type' => 'temperature',
                'location' => 'Ruang Lab Kalibrasi',
                'status' => 'inactive',
            ],
        ];

        $deviceModels = [];
        foreach ($devices as $dev) {
            $deviceModels[] = SensorDevice::updateOrCreate(['device_code' => $dev['device_code']], $dev);
        }

        // 4. Seed Sensor Readings & Contamination Logs
        // Reading 1: Aman
        $reading1 = SensorReading::create([
            'sensor_device_id' => $deviceModels[0]->id,
            'food_category_id' => $categoryModels[0]->id,
            'sample_name' => 'Sampel Daging Mentah A',
            'temperature' => 4.20,
            'humidity' => 68.00,
            'gas_level' => 120.00,
            'is_anomaly' => false,
            'safety_status' => 'aman',
            'notes' => 'Suhu stabil di area dingin, tidak terdeteksi kontaminasi gas pembusukan.',
            'read_at' => now()->subHours(2),
        ]);

        $deviceModels[0]->update(['last_reading_at' => $reading1->read_at]);

        // Reading 2: Waspada (Gas mulai meningkat)
        $reading2 = SensorReading::create([
            'sensor_device_id' => $deviceModels[1]->id,
            'food_category_id' => $categoryModels[1]->id,
            'sample_name' => 'Sampel Selada Hidroponik',
            'temperature' => 12.50, // Agak hangat untuk chiller sayur
            'humidity' => 78.00,
            'gas_level' => 220.00, // Diatas batas waspada 200
            'is_anomaly' => true,
            'safety_status' => 'waspada',
            'notes' => 'Suhu chiller agak meningkat, kelembapan cukup tinggi, indikasi awal pembusukan daun sayur.',
            'read_at' => now()->subHours(1),
        ]);

        $deviceModels[1]->update(['last_reading_at' => $reading2->read_at]);

        ContaminationLog::create([
            'sensor_reading_id' => $reading2->id,
            'sensor_device_id' => $deviceModels[1]->id,
            'food_category_id' => $categoryModels[1]->id,
            'type' => 'Anomali Suhu & Kelembapan Chiller',
            'severity' => 'terkontaminasi',
            'description' => 'Suhu pendingin sayur terdeteksi meningkat mencapai 12.5°C dengan indikasi awal peningkatan gas volatil.',
            'status' => 'investigasi',
            'detected_at' => $reading2->read_at,
        ]);

        // Reading 3: Bahaya (Gas dekomposisi daging)
        $reading3 = SensorReading::create([
            'sensor_device_id' => $deviceModels[0]->id,
            'food_category_id' => $categoryModels[0]->id,
            'sample_name' => 'Daging Cincang Stock-B',
            'temperature' => 18.20, // Sangat hangat (danger zone)
            'humidity' => 86.00, // Kelembapan sangat tinggi
            'gas_level' => 450.00, // Diatas batas bahaya 400
            'is_anomaly' => true,
            'safety_status' => 'bahaya',
            'notes' => 'Deteksi bau gas amonia/pembusukan tinggi pada sampel daging cincang.',
            'read_at' => now()->subMinutes(15),
        ]);

        $deviceModels[0]->update(['last_reading_at' => $reading3->read_at]);

        ContaminationLog::create([
            'sensor_reading_id' => $reading3->id,
            'sensor_device_id' => $deviceModels[0]->id,
            'food_category_id' => $categoryModels[0]->id,
            'type' => 'Dekomposisi Gas Tinggi (Amonia)',
            'severity' => 'berbahaya',
            'description' => 'Tingkat kontaminasi gas volatil mencapai 450 ppm pada daging cincang dengan suhu ruang penyimpanan berbahaya (18.2°C).',
            'status' => 'terdeteksi',
            'detected_at' => $reading3->read_at,
        ]);
    }
}
