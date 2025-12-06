<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('passengers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            
            $table->enum('title', ['Mr', 'Mrs', 'Ms', 'Miss', 'Mstr']);
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->date('date_of_birth');
            $table->string('nationality'); // ID, SG, US
            $table->string('passport_number')->nullable(); // Opsional jika domestik (bisa pakai NIK)
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('passengers');
    }
};