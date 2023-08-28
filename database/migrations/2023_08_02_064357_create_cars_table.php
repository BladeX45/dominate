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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            // carName
            $table->string('carName');
            // carModel
            $table->string('carModel');
            // Transmission
            $table->enum('Transmission',['manual','automatic']);
            // carYear
            $table->integer('carYear');
            // carColor
            $table->string('carColor');
            // carPlateNumber
            $table->string('carPlateNumber');
            // carImage
            $table->string('carImage');
            // carStatus
            $table->enum('carStatus',['available','unavailable']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
