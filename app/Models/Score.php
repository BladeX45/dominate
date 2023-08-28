<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customerID');
    }

    public function instructor()
    {
        return $this->belongsTo(instructors::class, 'instructorID');
    }
}
