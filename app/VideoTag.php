<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VideoTag extends Model
{
    //
    protected $fillable = [
        'name', 'active'
    ];
    public $timestamps = false;
}
