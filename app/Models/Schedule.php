<?php

namespace App\Models;

use App\Models\Instructor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Schedule extends Model
{
    use HasFactory;

    protected $guarded = [];

    // instructor
    public function instructor()
    {
        return $this->belongsTo(Instructor::class, 'instructorID');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customerID');
    }

    public function car()
    {
        return $this->belongsTo(Car::class, 'carID');
    }

    public function score()
    {
        return $this->hasOne(Score::class, 'scheduleID');
    }

}
