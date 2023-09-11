<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $guarded = [];

    // relationship transactions
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'planID');
    }
}
