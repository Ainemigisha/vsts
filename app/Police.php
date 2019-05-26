<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Police extends Model
{
    protected $fillable = ['address','username','role'];

    public function user()
	{
		return $this->belongsTo('App\User','id');
	}
}
