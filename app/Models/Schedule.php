<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function instructor()
    {
        return $this->belongsTo(instructors::class, 'instructorID');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customerID');
    }

    public function car()
    {
        return $this->belongsTo(Car::class, 'carID');
    }
}
