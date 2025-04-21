<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('device_code')->unique(); // Unique code for each device
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key linking to the users table
            $table->string('status')->default('offline'); // Status of the device (e.g., offline, online)
            $table->timestamp('last_heartbeat')->nullable(); // The last time the device sent a heartbeat
            $table->timestamps(); // Laravel's default created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
