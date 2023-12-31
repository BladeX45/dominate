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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            // fk users
            $table->unsignedBigInteger('customerID');
            $table->foreign('customerID')->references('id')->on('customers');
            // fk instructors
            $table->unsignedBigInteger('instructorID');
            $table->foreign('instructorID')->references('id')->on('instructors');
            // fk car
            $table->unsignedBigInteger('carID');
            $table->foreign('carID')->references('id')->on('cars');
            // date
            $table->date('date');
            // session
            $table->string('session');
            // status
            $table->string('status');
            // isConfirmed
            $table->boolean('isConfirmed')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
