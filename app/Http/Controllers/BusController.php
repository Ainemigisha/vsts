<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bus;
use App\Penalty;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;

class BusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->category == "bus_admin") {
            $company_id = Auth::user()->id;  
            $buses = Bus::join('bus_companies', 'bus_companies.id', '=', 'buses.bus_company_id')
                ->leftjoin('location_finders', 'buses.id', '=', 'location_finders.bus_id')
                ->leftjoin('locations', 'locations.location_finder_id', '=', 'location_finders.id')
                ->leftjoin('penalties', 'penalties.location_id', '=', 'locations.id')
                ->select('buses.id','number_plate','bus_companies.company_name',DB::raw('COUNT(penalties.id) as total_penalties'),DB::raw('AVG(locations.speed) as avg_speed'))
                ->where('bus_companies.id',$company_id)
                ->groupby('buses.id')
                ->orderby('buses.updated_at','DESC')
                ->get(); 
      }else{
        $buses = Bus::join('bus_companies', 'bus_companies.id', '=', 'buses.bus_company_id')
        ->leftjoin('location_finders', 'buses.id', '=', 'location_finders.bus_id')
        ->leftjoin('locations', 'locations.location_finder_id', '=', 'location_finders.id')
        ->leftjoin('penalties', 'penalties.location_id', '=', 'locations.id')
        ->select('buses.id','number_plate','bus_companies.company_name',DB::raw('COUNT(penalties.id) as total_penalties'),DB::raw('AVG(locations.speed) as avg_speed'))
        ->groupby('buses.id')
        ->orderby('buses.updated_at','DESC')
        ->get();
      }
     
     
        return view('buses.index',compact('buses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bus_controller = new BusCompanyController();
        $bus_companies = $bus_controller->getCompanyList();
       

        return view('buses.create',compact('bus_companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return response()->json($request);
        $bus = Bus::create([
            'bus_company_id'=>$request->company,
            'driver_name'=>$request->driver_name,
            'number_plate'=>$request->num_plate
        ]);
        return redirect('/buses');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $bus_profile = Bus::with("bus_company")
                ->find($id);
        
        $bus_stat_overall = Bus::leftjoin('location_finders', 'buses.id', '=', 'location_finders.bus_id')
                ->leftjoin('locations', 'locations.location_finder_id', '=', 'location_finders.id')
                ->leftjoin('penalties', 'penalties.location_id', '=', 'locations.id')
                ->select(DB::raw('COUNT(penalties.id) as total_penalties'), DB::raw('AVG(locations.speed) as avg'))
                ->find($id);

        $bus_stat_today = Bus::leftjoin('location_finders', 'buses.id', '=', 'location_finders.bus_id')
                ->leftjoin('locations', 'locations.location_finder_id', '=', 'location_finders.id')
                ->leftjoin('penalties', 'penalties.location_id', '=', 'locations.id')
                ->select(DB::raw('COUNT(penalties.id) as total_penalties'), DB::raw('AVG(locations.speed) as avg'))
                ->whereDate('locations.created_at', Carbon::today())
                ->find($id);

        $penalties = Bus::leftjoin('location_finders', 'buses.id', '=', 'location_finders.bus_id')
                ->leftjoin('locations', 'locations.location_finder_id', '=', 'location_finders.id')
                ->leftjoin('penalties', 'penalties.location_id', '=', 'locations.id')
                ->leftjoin('police as assigner', 'penalties.assigned_by', '=', 'assigner.id')
                ->leftjoin('users as a_user', 'a_user.id', '=', 'assigner.id')
                ->leftjoin('police as clearer', 'penalties.cleared_by', '=', 'clearer.id')
                ->leftjoin('users as c_user', 'c_user.id', '=', 'clearer.id')
                ->select('a_user.name as assigner_name','c_user.name as clearer_name','penalties.created_at as assigned_on', 'cleared_date','penalties.speed as speed')
                ->where('buses.id',$id)
                ->take(5)
                ->get();

        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $months = ['January'=>'01','February'=>'02','March'=>'03','April'=>'04','May'=>'05','June'=>'06','July'=>'07','August'=>'08','September'=>'09',
                'October'=>'10','November'=>'11','December'=>'12'];

        
        foreach ($months as $month_name => $month_val) {
            $line_average_speeds[] = (!is_null($this->getLineAverageSpeeds($year,$month_val,$id)->avg)) ? $this->getLineAverageSpeeds($year,$month_val,$id)->avg : 0;                                
        }
                
        
       
 
        //return response()->json($line_average_speeds);
        return view('buses.show',compact('bus_profile','bus_stat_overall','bus_stat_today','penalties','line_average_speeds','months'));
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

    public function getBusesList()
    {
        $buses = Bus::orderby('updated_at','desc')
            ->get();
            
        return $buses;
    }

    public function getTotalBuses($company_id = null)
    {
        if ($company_id == null) {
            $totalBuses = Bus::count('id');
        }else{
            $totalBuses = Bus::with('bus_company')
                ->whereHas('bus_company', function($query) use ($company_id) {
                    $query->where('id',$company_id);
                    })
                ->count('id');
        }
       

       return $totalBuses;
    }

    private function getLineAverageSpeeds($year,$month,$bus_id)
    {
        $bus_speeds = Bus::leftjoin('location_finders', 'buses.id', '=', 'location_finders.bus_id')
                ->leftjoin('locations', 'locations.location_finder_id', '=', 'location_finders.id')
                ->select(DB::raw('AVG(locations.speed) as avg'))
                ->where('buses.id',$bus_id)
                ->whereYear('locations.created_at',$year)
                ->whereMonth('locations.created_at',$month)
                ->first();

        return $bus_speeds;
    }
}
