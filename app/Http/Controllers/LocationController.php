<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Penalty;
use App\Location_finder;
use App\Bus_admin;
use Auth;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $speed=$this->get_daily_average_speed();
       // return $speeds;
        return view('police_admin.dashboard',compact('speed'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $date = Carbon::create($request->year,$request->mon,$request->dy,$request->hr,$request->mn,$request->sc,'UTC');
        $date->addHours(3);


        $lf_controller = new LocationFinderController();
        $location_finder_id = $lf_controller->getLocationFinder($request->device_id);
        
       
        /*$location = Location::create(
            ['latitude'=>$request->latitude,
                'longitude'=>$request->longitude,
                'speed'=>$request->speed,
                'timestamp'=>$date,
                'location_finder_id'=>$location_finder_id
             ]
        );*/

        $location = new Location();
        $location->latitude = $request->latitude;
        $location->longitude = $request->longitude;
        $location->speed = $request->speed;
        $location->updated_at = $date;
        $location->created_at = $date;
        $location->location_finder_id = $location_finder_id;
        $location->save();
        
        if($request->speedFlag == 1){
            $penalty = Penalty::create([
                'location_finder_id'=> $location_finder_id,
                'location_id'=> $location->id,
                'latitude'=> $request->latitude,
                'longitude'=> $request->longitude,
                'status'=>'Provisional',
                'speed'=> $request->averageSpeed
                
            ]);

            $finder = Location_finder::where('id', $location_finder_id)
                ->update(['flag' => 1]);
        }
        
        return response()->json($location);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function displayGrid(){

        //$locations = DB::select("SELECT MAX(updated_at),location_finder_id FROM locations GROUP BY location_finder_id ");
        if (Auth::user()->category == "bus_admin") {
            $company_id = Bus_admin::where('id',Auth::user()->id)
                ->pluck('company_id')
                ->first(); 

            $locations = Location::with('location_finder.bus.bus_company')
                ->whereIn('locations.updated_at', function($query)
                    {
                        $query->select(DB::raw('MAX(updated_at) as updated_at'))
                            ->from('locations')
                            ->groupBy('location_finder_id');
                    })
                ->whereHas('location_finder.bus.bus_company', function($query) use ($company_id) {
                        $query->where('id',$company_id);
                    })
            
            ->orderBy('updated_at')
            
            ->get();
        }else{
            $locations = Location::with('location_finder.bus.bus_company')
                ->whereIn('locations.updated_at', function($query)
                {
                    $query->select(DB::raw('MAX(updated_at) as updated_at'))
                        ->from('locations')
                        ->groupBy('location_finder_id');
                })
            
            ->orderBy('updated_at')
            
            ->get();
        }


        /*$locations = Location::with('location_finder.bus.bus_company')
                ->whereIn('locations.updated_at', function($query)
                {
                    $query->select(DB::raw('MAX(updated_at) as updated_at'))
                        ->from('locations')
                        ->groupBy('location_finder_id');
                })
            
            ->orderBy('updated_at')
            
            ->get();*/

        //return response()->json($locations);

       return response(view('bus_admin.xml_feed')->with('locations', $locations), 200, [
           'Content-Type' => 'application/xml'
        ]);
    }

    public function api_get_locations(Request $request)
    {
        //$locations = DB::table('locations')
        $locations = Location::with('location_finder.bus.bus_company')
            ->whereIn('locations.updated_at', function($query)
                {
                    $query->select(DB::raw('MAX(updated_at) as updated_at'))
                        ->from('locations')
                        ->groupBy('location_finder_id');
                })
            
            ->orderBy('updated_at')
            ->get();
        $vicinity_locations = array();
        foreach($locations as $location){
            if ($this->getDistance($location->latitude,$location->longitude,$request->latitude,$request->longitude) <= 10) {
                
               $vicinity_locations[] = $location;
            }
        }

        return response()->json($vicinity_locations);
    }

    

    public function get_daily_average_speed(){
        $speeds=Location::daily_average_speed();
        return response()->json($speeds);
        return $speeds;
    }

    public function getTotalAverageSpeed($company = null){
        if($company == null){
            $av_speed["overall"] = Location::avg('speed');

            $av_speed["today"] = Location::whereDate('created_at', Carbon::today())
                ->avg('speed');
        }else{
            $av_speed["overall"] = Location::with('location_finder.bus.bus_company')
                ->whereHas('location_finder.bus.bus_company', function($query) use ($company) {
		            $query->where('id',$company);
	                })
                ->avg('speed');

            $av_speed["today"] = Location::with('location_finder.bus.bus_company')
                ->whereHas('location_finder.bus.bus_company', function($query) use ($company) {
                    $query->where('id',$company);
                    })
                ->whereDate('created_at', Carbon::today())
                ->avg('speed');
        }
        


        return $av_speed;
    }

    private function getDistance($lat1, $lon1, $lat2, $lon2) {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
          return 0;
        }
        else {
          $theta = $lon1 - $lon2;
          $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
          $dist = acos($dist);
          $dist = rad2deg($dist);
          $miles = $dist * 60 * 1.1515;
      
          return ($miles * 1.609344);
        }
      }
}
