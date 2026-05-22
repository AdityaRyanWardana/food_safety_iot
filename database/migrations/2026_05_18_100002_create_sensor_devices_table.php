<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sensor_devices', function (Blueprint $table) {
            $table->id();
            $table->string('device_code')->unique();
            $table->string('name');
            $table->enum('type', ['temperature', 'humidity', 'gas', 'ph', 'multi'])->default('multi');
            $table->string('location')->nullable();
            $table->enum('status', ['active', 'inactive', 'maintenance'])->default('active');
            $table->timestamp('last_reading_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sensor_devices');
    }
};
