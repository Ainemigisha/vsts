<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    protected $fillable = ['number_plate','driver_name','bus_company_id'];

    public function bus_company()
	{
		return $this->belongsTo('App\Bus_company','bus_company_id');
	}

	public function location_finders()
	{
		return $this->hasMany('App\Location_finder');
	}
}
