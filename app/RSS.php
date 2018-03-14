<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RSS extends Model
{
    //
    protected $fillable = [
        'domainName', 'menuTag', 'bodyTag', 'exceptTag', 'ignoreHomePage', 'active'
    ];
    public $timestamps = false;
}
