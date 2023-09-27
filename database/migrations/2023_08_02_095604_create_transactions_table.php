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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            // fk users
            $table->unsignedBigInteger('userID');
            $table->foreign('userID')->references('id')->on('users');
            // fk plan
            $table->unsignedBigInteger('planID');
            $table->foreign('planID')->references('id')->on('plans');

            // plan amount min value = 1
            $table->integer('planAmount');
            // totalSession
            $table->integer('totalSession');
            // transactionID
            $table->string('transactionID');
            // paymentMethod (transfer or cash) enum
            $table->enum('paymentMethod', ['transfer', 'cash']);
            // paymentStatus
            $table->string('paymentStatus');
            // paymentAmount
            $table->string('paymentAmount');
            // transfer receipt
            $table->text('receiptTransfer')->nullable()->default(null);
            // created_at & updated_at
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
