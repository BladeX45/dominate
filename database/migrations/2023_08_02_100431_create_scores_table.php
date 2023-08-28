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
        Schema::create('scores', function (Blueprint $table) {
            $table->id();
            // fk users
            $table->unsignedBigInteger('customerID');
            $table->foreign('customerID')->references('id')->on('customers');
            // fk instructors
            $table->unsignedBigInteger('instructorID');
            $table->foreign('instructorID')->references('id')->on('instructors');
            // fk schedules
            $table->unsignedBigInteger('scheduleID');
            $table->foreign('scheduleID')->references('id')->on('schedules');

            // isFinal
            $table->boolean('isFinal')->default(0);

            $table->string('theoryKnowledge');
            $table->string('practicalDriving');
            $table->string('hazardPerception');
            $table->string('trafficRulesCompliance');
            $table->string('confidenceAndAttitude');
            $table->string('overallAssessment');
            $table->string('additionalComment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scores');
    }
};
