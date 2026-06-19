<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\ContaminationController;
use App\Http\Controllers\FoodCategoryController;
use App\Http\Controllers\SensorTestController;

Route::get('/', function () {
    return view('index');
});

Route::get('/api/latest-metric', function () {
    $latestReading = \App\Models\SensorReading::with(['sensorDevice', 'foodCategory'])->latest('read_at')->first();
    
    if (!$latestReading) {
        return response()->json(null);
    }

    return response()->json([
        'temperature' => $latestReading->temperature,
        'humidity' => $latestReading->humidity,
        'temperature_location' => $latestReading->sensorDevice ? $latestReading->sensorDevice->location : 'Cold Storage A',
        'gas_level' => $latestReading->gas_level,
        'gas_location' => $latestReading->sample_name ?? 'Daging Sapi Lot B',
        'gas_status' => $latestReading->is_anomaly ? 'Waspada' : 'Aman',
        'safety_status' => $latestReading->safety_status ?? ($latestReading->is_anomaly ? 'Terdeteksi Anomali' : 'Pangan Steril & Aman'),
        'is_anomaly' => $latestReading->is_anomaly
    ]);
});

// API Endpoint for ESP32 to send data
Route::post('/api/sensor-data', [SensorTestController::class, 'storeReading'])
    ->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', function () {
        $sensorDevices = \App\Models\SensorDevice::all();
        $activeSensors = $sensorDevices->where('status', 'active')->count();
        $warningsToday = \App\Models\ContaminationLog::whereDate('detected_at', \Carbon\Carbon::today())
            ->where('status', '!=', 'teratasi')
            ->count();
        
        $avgTemp = \App\Models\SensorReading::avg('temperature') ?? 0;
        $avgHum = \App\Models\SensorReading::avg('humidity') ?? 0;

        $categories = \App\Models\FoodCategory::all();

        $recentReadings = \App\Models\SensorReading::with(['sensorDevice', 'foodCategory'])
            ->latest('read_at')
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('sensorDevices', 'activeSensors', 'warningsToday', 'avgTemp', 'avgHum', 'recentReadings', 'categories'));
    })->name('admin.dashboard');

    Route::get('/admin/profile', [ProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::put('/admin/profile', [ProfileController::class, 'update'])->name('admin.profile.update');

    // Data Sensor IoT
    Route::get('/admin/sensors', [SensorController::class, 'index'])->name('admin.sensors.index');
    Route::post('/admin/sensors', [SensorController::class, 'store'])->name('admin.sensors.store');
    Route::delete('/admin/sensors/{device}', [SensorController::class, 'destroy'])->name('admin.sensors.destroy');

    // Log Kontaminasi
    Route::get('/admin/contamination', [ContaminationController::class, 'index'])->name('admin.contamination.index');
    Route::patch('/admin/contamination/{log}/status', [ContaminationController::class, 'updateStatus'])->name('admin.contamination.updateStatus');
    Route::delete('/admin/contamination-clear', [ContaminationController::class, 'clearAll'])->name('admin.contamination.clear');
    Route::delete('/admin/contamination/{log}', [ContaminationController::class, 'destroy'])->name('admin.contamination.destroy');

    // Kategori Pangan
    Route::get('/admin/categories', [FoodCategoryController::class, 'index'])->name('admin.categories.index');
    Route::post('/admin/categories', [FoodCategoryController::class, 'store'])->name('admin.categories.store');
    Route::put('/admin/categories/{category}', [FoodCategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/admin/categories/{category}', [FoodCategoryController::class, 'destroy'])->name('admin.categories.destroy');

    // Hapus Log Pemantauan Real-time
    Route::delete('/admin/readings-clear', [SensorController::class, 'clearAllReadings'])->name('admin.readings.clear');
    Route::delete('/admin/readings/{reading}', [SensorController::class, 'destroyReading'])->name('admin.readings.destroy');

    // Pengetesan Pangan (USB Sensor)
    Route::get('/admin/testing', [SensorTestController::class, 'index'])->name('admin.testing.index');
    Route::post('/admin/testing/store', [SensorTestController::class, 'storeReading'])->name('admin.testing.store');
});
