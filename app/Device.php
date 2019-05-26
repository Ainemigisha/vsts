<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = ['alphanumeric_string'];

    public function location_finders()
	{
		return $this->hasMany('App\Location_finders','alphanumeric_string');
	}
}
