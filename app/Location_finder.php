<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location_finder extends Model
{
    protected $fillable = ['bus_id','device_id','status','flag','driver_name'];

    public function device()
	{
		return $this->belongsTo('App\Device','device_id','alphanumeric_string');
    }
    
    public function bus()
	{
		return $this->belongsTo('App\Bus');
	}

	public function penalties()
	{
		return $this->hasMany('App\Penalty');
	}

	public function locations()
	{
		return $this->hasMany('App\Location');
	}
}
