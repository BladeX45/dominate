<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashFlow extends Model
{
    use HasFactory;

    // protected table
    protected $table = 'cashflows';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    public function plan(){
        return $this->belongsTo(Plan::class, 'planID');
    }

    // customer
    public function customer(){
        return $this->belongsTo(Customer::class,'userID', 'userID');
    }

    // instructor
    public function instructor(){
        return $this->belongsTo(Instructor::class,'userID', 'userID');
    }

    // Transaction
    public function transaction(){
        return $this->belongsTo(Transaction::class,'transaction_id');
    }

    // expense
    public function expense(){
        return $this->belongsTo(Expense::class, 'expense_id');
    }
}
