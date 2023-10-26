<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'userID');
    }

    public function scores()
    {
        return $this->hasMany('App\Models\Score', 'customerID');
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction', 'customerID');
    }

    public function schedules()
    {
        return $this->hasMany('App\Models\Schedule', 'customerID');
    }

    public function certificates()
    {
        return $this->hasMany('App\Models\Certificate', 'customerID');
    }


}
