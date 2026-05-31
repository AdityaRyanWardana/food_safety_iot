<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sensor_readings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sensor_device_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('food_category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('sample_name')->nullable();
            $table->decimal('temperature', 8, 2)->nullable();
            $table->decimal('humidity', 8, 2)->nullable();
            $table->decimal('gas_level', 8, 2)->nullable();
            $table->boolean('is_anomaly')->default(false);
            $table->enum('safety_status', ['aman', 'waspada', 'bahaya'])->default('aman');
            $table->text('notes')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sensor_readings');
    }
};
