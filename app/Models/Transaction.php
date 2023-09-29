<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

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



}
