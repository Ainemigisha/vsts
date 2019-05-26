<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bus_admin extends Model
{
    public function company()
	{
		return $this->belongsTo('App\Bus_company','company_id','id');
	}
}
