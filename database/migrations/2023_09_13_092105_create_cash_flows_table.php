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
        Schema::create('cashflows', function (Blueprint $table) {
            $table->id();
            // fk transaction -> nullable
            $table->foreignId('transaction_id')->nullable()->constrained('transactions')->onDelete('cascade');
            // fk expense -> nullable
            $table->foreignId('expense_id')->nullable()->constrained('expenses')->onDelete('cascade');
            // fk income -> nullable
            $table->string('debitAmount')->nullable();
            // credit
            $table->string('creditAmount')->nullable();
            // date
            $table->string('date')->nullable();
            // balance
            $table->string('balance')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_flows');
    }
};
