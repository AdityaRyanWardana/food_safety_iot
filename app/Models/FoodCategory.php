<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FoodCategory extends Model
{
    protected $fillable = ['name', 'description', 'icon', 'image', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function sensorReadings(): HasMany
    {
        return $this->hasMany(SensorReading::class);
    }

    public function contaminationLogs(): HasMany
    {
        return $this->hasMany(ContaminationLog::class);
    }
}
