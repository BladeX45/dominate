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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            // firstName
            $table->string('firstName');
            // lastName
            $table->string('lastName')->nullable()->default(null);
            // National Identity Number
            $table->string('NIN')->unique();
            // gender  = M/ F/ O
            $table->enum('gender',['Male', 'Female', 'Other']);
            // birthDate format DD/MM/YYYY
            $table->date('birthDate');
            // address
            $table->string('address');
            // phone
            $table->string('phone');
            // total session -> default null
            $table->integer('ManualSession')->nullable()->default(null);
            $table->integer('MaticSession')->nullable()->default(null);
            // certificate -> default null
            $table->string('certificate')->nullable()->default(null);

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
        Schema::dropIfExists('customers');
    }
};
