<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('airports', function (Blueprint $table) {
            $table->id();
            $table->string('iata_code')->unique(); // Misal: CGK, DPS
            $table->string('name'); // Bandara I Gusti Ngurah Rai
            $table->string('city'); // Denpasar
            $table->string('country'); // Indonesia
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('airports');
    }
};