<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['speed','location_finder_id','latitude','longitude'];

    public function scopeLocation_finder()
	{
		return $this->belongsTo(Location_finder::Class);
	}

	public function scopeDaily_average_speed(){
		return $this->avg('speed');
	}

	public function location_finder()
	{
		return $this->belongsTo(Location_finder::Class);
	}

	public function penalty()
	{
		return $this->hasOne("App\Penalty");
	}

}
