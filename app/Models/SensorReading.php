<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SensorReading extends Model
{
    protected $fillable = [
        'sensor_device_id', 'food_category_id', 'sample_name',
        'temperature', 'humidity', 'gas_level',
        'is_anomaly', 'safety_status', 'notes', 'read_at',
    ];

    protected $casts = [
        'temperature' => 'decimal:2',
        'humidity' => 'decimal:2',
        'gas_level' => 'decimal:2',
        'is_anomaly' => 'boolean',
        'read_at' => 'datetime',
    ];

    public function sensorDevice(): BelongsTo
    {
        return $this->belongsTo(SensorDevice::class);
    }

    public function foodCategory(): BelongsTo
    {
        return $this->belongsTo(FoodCategory::class);
    }

    public function contaminationLog(): HasOne
    {
        return $this->hasOne(ContaminationLog::class);
    }
}
