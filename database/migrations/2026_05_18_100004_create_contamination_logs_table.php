<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contamination_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sensor_reading_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('sensor_device_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('food_category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type');
            $table->enum('severity', ['aman', 'terkontaminasi', 'berbahaya'])->default('aman');
            $table->text('description')->nullable();
            $table->enum('status', ['terdeteksi', 'investigasi', 'teratasi'])->default('terdeteksi');
            $table->timestamp('detected_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contamination_logs');
    }
};
