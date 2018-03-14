<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KeyWord extends Model
{
    //
    protected $fillable = [
        'name', 'active'
    ];
    public $timestamps = false;
}
