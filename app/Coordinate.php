<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coordinate extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'address','country','phone','postal_code'
    ];
}
