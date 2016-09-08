<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coordinate extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'address','country','phone','postal_code', 'user_id'
    ];
}
