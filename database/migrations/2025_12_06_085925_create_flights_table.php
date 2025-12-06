<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->string('flight_number'); // GA-123
            $table->foreignId('airline_id')->constrained('airlines')->onDelete('cascade');
            
            // Relasi ke Airport (Asal & Tujuan)
            $table->foreignId('origin_airport_id')->constrained('airports')->onDelete('cascade');
            $table->foreignId('destination_airport_id')->constrained('airports')->onDelete('cascade');
            
            $table->dateTime('departure_time');
            $table->dateTime('arrival_time');
            
            // Harga per seat
            $table->decimal('price', 15, 2); 
            
            // Kelas & Kuota
            $table->enum('class', ['economy', 'business', 'first'])->default('economy');
            $table->integer('available_seats')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};