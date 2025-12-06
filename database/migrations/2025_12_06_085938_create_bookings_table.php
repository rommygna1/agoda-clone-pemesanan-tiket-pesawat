<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->unique(); // Kode Unik Transaksi
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('flight_id')->constrained('flights')->onDelete('cascade');
            
            $table->integer('total_passengers');
            $table->decimal('total_amount', 15, 2);
            
            // Status Pembayaran
            $table->enum('status', ['pending', 'paid', 'cancelled', 'failed'])->default('pending');
            
            // Midtrans Token
            $table->string('snap_token')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};