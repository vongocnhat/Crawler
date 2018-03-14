<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailWebsite extends Model
{
    //
    protected $fillable = [
        'domainName', 'containerTag', 'titleTag', 'summaryTag', 'updateTimeTag', 'active'
    ];

    public function Websites()
    {
        return $this->belongsTo('App\Website', 'domainName', 'domainName');
    }

    public $timestamps = false;
}
