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
        Schema::create('instructors', function (Blueprint $table) {
            $table->id();
            // firstName
            $table->string('firstName');
            // lastName
            $table->string('lastName')->nullable()->default(null);
            // enum gender
            $table->enum('gender',['male','female','Other']);
            // birthDate format DD/MM/YYYY
            $table->date('birthDate');
            // address
            $table->string('address');
            // phone
            $table->string('phone');
            // driving Experience
            $table->integer('drivingExperience');
            // certificate
            $table->string('certificate');
            // rating
            $table->float('rating');

            // fk from user
            $table->unsignedBigInteger('userID');
            $table->foreign('id')->references('id')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instructures');
    }
};
