<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bus_company extends Model
{
    protected $fillable = ['company_name'];

    public function bus()
	{
		return $this->hasMany('App\Bus','bus_company_id');
	}

}
