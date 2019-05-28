<?php

namespace App\Http\Controllers;

use App\Bus_admin;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\Bus_company;
use Illuminate\Support\Facades\DB;

class BusAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');   
        $this->middleware('bus_admin'); 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bus_admin = Bus_admin::with('company')
                ->where('id',Auth::user()->id)
                ->first();
                
        
        $company_id = $bus_admin->company->id;
        $company_name = $bus_admin->company->company_name;
        $av_speeds = (new LocationController())->getTotalAverageSpeed($company_id);
        $overall_av_speed = number_format($av_speeds["overall"],2);
        $today_av_speed = number_format($av_speeds["today"],2);
        $total_penalties = (new PenaltyController())->getTotalPenalties($company_id);
        $total_buses = (new BusController())->getTotalBuses($company_id);

        $buseswithHighestAvgSpeeds = $this->getBusesWithHighestAvgSpeed($company_id);
        $busesWithMostPenalties = $this->getBusesWithMostPenalties($company_id);
        $areasWithMostPenalties = $this->getAreasWithMostPenalties($company_id);

        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $months = ['January'=>'01','February'=>'02','March'=>'03','April'=>'04','May'=>'05','June'=>'06','July'=>'07','August'=>'08','September'=>'09',
                'October'=>'10','November'=>'11','December'=>'12'];

        
        foreach ($months as $month_name => $month_val) {
            $line_average_speeds[] = (!is_null($this->getLineAverageSpeeds($year,$month_val,$company_id)->avg)) ? $this->getLineAverageSpeeds($year,$month_val,$company_id)->avg : 0;    
            $line_sum_penalties[] = (!is_null($this->getLineTotalPenalties($year,$month_val,$company_id)->total)) ? $this->getLineTotalPenalties($year,$month_val,$company_id)->total : 0;                             
        }

        //return response()->json($av_speeds);
        return view('bus_admin.index',compact('company_name','line_average_speeds','line_sum_penalties','overall_av_speed','today_av_speed','total_penalties','total_buses','months','buseswithHighestAvgSpeeds','busesWithMostPenalties','areasWithMostPenalties'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bus_admin  $bus_admin
     * @return \Illuminate\Http\Response
     */
    public function show(Bus_admin $bus_admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bus_admin  $bus_admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Bus_admin $bus_admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bus_admin  $bus_admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bus_admin $bus_admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bus_admin  $bus_admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bus_admin $bus_admin)
    {
        //
    }

    private function getLineAverageSpeeds($year,$month,$company_id)
    {
        $bus_speeds = Bus_company::leftjoin('buses', 'bus_companies.id', '=', 'buses.bus_company_id')
                ->leftjoin('location_finders', 'buses.id', '=', 'location_finders.bus_id')
                ->leftjoin('locations', 'locations.location_finder_id', '=', 'location_finders.id')
                ->select(DB::raw('AVG(locations.speed) as avg'))
                ->where('bus_companies.id',$company_id)
                ->whereYear('locations.created_at',$year)
                ->whereMonth('locations.created_at',$month)
                ->first();

        return $bus_speeds;
    }

    private function getLineTotalPenalties($year,$month,$company_id)
    {
        $bus_speeds = Bus_company::leftjoin('buses', 'bus_companies.id', '=', 'buses.bus_company_id')
                ->leftjoin('location_finders', 'buses.id', '=', 'location_finders.bus_id')
                ->leftjoin('locations', 'locations.location_finder_id', '=', 'location_finders.id')
                ->leftjoin('penalties', 'penalties.location_id', '=', 'locations.id')
                ->select(DB::raw('COUNT(penalties.id) as total'))
                ->where('bus_companies.id',$company_id)
                ->whereYear('locations.created_at',$year)
                ->whereMonth('locations.created_at',$month)
                ->first();

        return $bus_speeds;
    }

    private function getBusesWithHighestAvgSpeed($company_id)
    {
        $bus_companies = Bus_company::leftjoin('buses', 'bus_companies.id', '=', 'buses.bus_company_id')
                ->leftjoin('location_finders', 'buses.id', '=', 'location_finders.bus_id')
                ->leftjoin('locations', 'locations.location_finder_id', '=', 'location_finders.id')
                ->select('number_plate', DB::raw('AVG(locations.speed) as avg'))
                ->where('bus_companies.id',$company_id)
                ->groupby('buses.id')
                ->orderby('avg','desc')
                ->take('3')
                ->get();

        return $bus_companies;
    }

    private function getAreasWithMostPenalties($company_id)
    {
        $bus_companies = Bus_company::leftjoin('buses', 'bus_companies.id', '=', 'buses.bus_company_id')
                ->leftjoin('location_finders', 'buses.id', '=', 'location_finders.bus_id')
                ->leftjoin('locations', 'locations.location_finder_id', '=', 'location_finders.id')
                ->leftjoin('penalties', 'penalties.location_id', '=', 'locations.id')
                ->select('place',DB::raw('COUNT(penalties.id) as total_penalties'), DB::raw('AVG(locations.speed) as avg'))
              //  ->whereYear('locations.created_at',$year)
                //->whereMonth('locations.created_at',$month)
                ->where('bus_companies.id',$company_id)
                ->groupby('penalties.place')
                ->orderby('total_penalties','desc')
                ->orderby('avg','desc')
                ->take('2')
                ->get();

        return $bus_companies;
    }

    private function getBusesWithMostPenalties($company_id)
    {
        $bus_companies = Bus_company::leftjoin('buses', 'bus_companies.id', '=', 'buses.bus_company_id')
                ->leftjoin('location_finders', 'buses.id', '=', 'location_finders.bus_id')
                ->leftjoin('locations', 'locations.location_finder_id', '=', 'location_finders.id')
                ->leftjoin('penalties', 'penalties.location_id', '=', 'locations.id')
                ->select('number_plate',DB::raw('COUNT(penalties.id) as total_penalties'), DB::raw('AVG(locations.speed) as avg'))
                ->where('bus_companies.id',$company_id)
                ->groupby('buses.id')
                ->orderby('total_penalties','desc')
                ->orderby('avg','desc')
                ->take('3')
                ->get();

        return $bus_companies;
    }
}
