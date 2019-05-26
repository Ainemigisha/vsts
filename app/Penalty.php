<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penalty extends Model
{
    //
    protected $fillable = ['assigned_by','cleared_by','location_finder_id','cleared_date','status','latitude','longitude','speed','location_id','place'];
    protected $dates = ['cleared_date'];

    public function assigner()
    {
        return $this->belongsTo('App\Police','assigned_by');
    }

    public function clearer()
    {
        return $this->belongsTo('App\Police','cleared_by');
    }

    public function locationFinder()
    {
        return $this->belongsTo('App\Location_finder');
    }

    public function location()
    {
        return $this->belongsTo('App\Location');
    }
    
}
