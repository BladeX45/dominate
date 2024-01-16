<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $disk = 'public';

    protected $guarded = [];

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'carID'); // Assuming you have a Schedule model
    }
}
