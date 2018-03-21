<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    //
    protected $fillable = [
        'domainName', 'menuTag', 'numberPage', 'limitOfOnePage', 'stringFirstPage', 'stringLastPage', 'bodyTag', 'exceptTag', 'active'
    ];
    
    public function DetailWebsites() {
    	// return $this->hasMany( ‘TenModel’ , ‘KhoaPhu’, ‘KhoaChinh’ );
    	return $this->hasMany('App\DetailWebsite' , 'domainName', 'domainName' );
    }

    public $timestamps = false;
}
