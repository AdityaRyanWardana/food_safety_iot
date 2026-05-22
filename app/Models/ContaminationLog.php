<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContaminationLog extends Model
{
    protected $fillable = [
        'sensor_reading_id', 'sensor_device_id', 'food_category_id',
        'type', 'severity', 'description', 'status',
        'detected_at', 'resolved_at',
    ];

    protected $casts = [
        'detected_at' => 'datetime',
        'resolved_at' => 'datetime',
    ];

    public function sensorReading(): BelongsTo
    {
        return $this->belongsTo(SensorReading::class);
    }

    public function sensorDevice(): BelongsTo
    {
        return $this->belongsTo(SensorDevice::class);
    }

    public function foodCategory(): BelongsTo
    {
        return $this->belongsTo(FoodCategory::class);
    }
}
