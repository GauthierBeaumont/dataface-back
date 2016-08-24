<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Society extends Model
{
    protected $fillable = [
        'name',
        'presentation',
        'mentionLegal',
        'cgv'
    ];
}
