<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rating extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function instructor()
    {
        return $this->belongsTo(Instructor::class, 'instructorID');
    }

    // average rate
    public static function avgRate($instructorID)
    {
        $avgRate = rating::where('instructorID', $instructorID)->avg('rate');
        return $avgRate;
    }

    // count rate
    public static function countRate($instructorID)
    {
        $countRate = rating::where('instructorID', $instructorID)->count('rate');
        return $countRate;
    }


}
