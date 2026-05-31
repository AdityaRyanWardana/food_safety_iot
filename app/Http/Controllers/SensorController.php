<?php

namespace App\Http\Controllers;

use App\Models\SensorDevice;
use App\Models\SensorReading;
use Illuminate\Http\Request;

class SensorController extends Controller
{
    public function index()
    {
        $devices = SensorDevice::withCount('readings')
            ->latest('last_reading_at')
            ->paginate(10);

        $totalActive = SensorDevice::where('status', 'active')->count();
        $totalInactive = SensorDevice::where('status', 'inactive')->count();
        $totalMaintenance = SensorDevice::where('status', 'maintenance')->count();

        return view('admin.sensors.index', compact('devices', 'totalActive', 'totalInactive', 'totalMaintenance'));
    }

    public function readings()
    {
        $readings = SensorReading::with(['sensorDevice', 'foodCategory'])
            ->latest('read_at')
            ->paginate(15);

        return view('admin.sensors.readings', compact('readings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'device_code' => 'required|string|unique:sensor_devices',
            'name' => 'required|string|max:255',
            'type' => 'required|in:temperature,humidity,gas,multi',
            'location' => 'nullable|string|max:255',
        ]);

        SensorDevice::create($request->all());

        return redirect()->route('admin.sensors.index')->with('success', 'Perangkat sensor berhasil ditambahkan.');
    }

    public function destroy(SensorDevice $device)
    {
        $device->delete();
        return redirect()->route('admin.sensors.index')->with('success', 'Perangkat sensor berhasil dihapus.');
    }

    public function destroyReading(SensorReading $reading)
    {
        $reading->delete();
        return redirect()->back()->with('success', 'Log pemantauan berhasil dihapus.');
    }

    public function clearAllReadings()
    {
        SensorReading::query()->delete();
        return redirect()->back()->with('success', 'Seluruh riwayat log pemantauan berhasil dihapus.');
    }
}
