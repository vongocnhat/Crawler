<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RSS extends Model
{
    //
    protected $fillable = [
        'domainName', 'menuTag', 'bodyTag', 'exceptTag', 'ignoreRSS', 'active'
    ];
    public $timestamps = false;
}
