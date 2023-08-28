<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $guarded = [];

    // generate random string for certificate hash
    public static function generateRandomString($length = 10) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)))),1,$length);
    }

    // check isExist
    public static function isExist($hash) {
        $certificate = Certificate::where('hash', $hash)->first();
        if ($certificate) {
            return true;
        } else {
            return false;
        }
    }


}
