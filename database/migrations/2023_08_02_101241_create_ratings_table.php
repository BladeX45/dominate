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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            // fk users
            $table->unsignedBigInteger('customerID');
            $table->foreign('customerID')->references('id')->on('customers');
            // fk instructors
            $table->unsignedBigInteger('instructorID');
            $table->foreign('instructorID')->references('id')->on('instructors');
            // fk schedule
            $table->unsignedBigInteger('scheduleID');
            $table->foreign('scheduleID')->references('id')->on('schedules');

            $table->string('rating');
            $table->string('comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
