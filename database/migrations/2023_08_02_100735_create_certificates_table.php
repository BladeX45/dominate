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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            // fk users
            $table->unsignedBigInteger('customerID');
            $table->foreign('customerID')->references('id')->on('customers');

            // fk score
            $table->unsignedBigInteger('scoreID');
            $table->foreign('scoreID')->references('id')->on('scores');

            // certificate date
            $table->date('certificateDate');
            // certificate number
            $table->string('certificateNumber');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
