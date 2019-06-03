<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bus_admin extends Model
{
    public function company()
	{
		return $this->hasOne('App\Bus_company','id','company_id');
	}

	public function user()
	{
		return $this->belongsTo('App\User','id','id');
	}
}
