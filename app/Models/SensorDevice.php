<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SensorDevice extends Model
{
    protected $fillable = ['device_code', 'name', 'type', 'location', 'status', 'last_reading_at'];

    protected $casts = [
        'last_reading_at' => 'datetime',
    ];

    public function readings(): HasMany
    {
        return $this->hasMany(SensorReading::class);
    }

    public function contaminationLogs(): HasMany
    {
        return $this->hasMany(ContaminationLog::class);
    }
}
