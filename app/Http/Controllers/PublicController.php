<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Bus_company;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PublicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');   
        $this->middleware('public'); 
    }

    public function index(Request $request)
    {
        $line_average_speeds = array();
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $months = ['January'=>'01','February'=>'02','March'=>'03','April'=>'04','May'=>'05','June'=>'06','July'=>'07','August'=>'08','September'=>'09',
                'October'=>'10','November'=>'11','December'=>'12'];
        $companies = Bus_company::all();
        $counter = 0;


        foreach ($companies as $company) {
            $line_average_speeds[$counter]['name'] = $company->company_name;
            foreach ($months as $month_name => $month_val) {
                $line_average_speeds[$counter]['data'][] = (!is_null($this->getLineAverageSpeeds($year,$month_val,$company->id))) ? $this->getLineAverageSpeeds($year,$month_val,$company->id)->avg : 0;                                
            }
            $counter++;
        }      

        $av_speeds = (new LocationController())->getTotalAverageSpeed();
        $overall_av_speed = number_format($av_speeds["overall"],2);
        $today_av_speed = number_format($av_speeds["today"],2);
        $total_penalties = (new PenaltyController())->getTotalPenalties(null,null);
        $total_buses = (new BusController())->getTotalBuses();

        $pie_av_speeds = $this->getPieAverageSpeeds('All',$year,'All');
        $companieswithHighestAvgSpeeds = $this->getCompaniesWithHighestAvgSpeed();
        $companiesWithMostPenalties = $this->getCompaniesWithMostPenalties();
        $areasWithMostPenalties = $this->getAreasWithMostPenalties();

        

  
       return view('public.index',compact('line_average_speeds','overall_av_speed','today_av_speed','total_penalties','total_buses','pie_av_speeds','months','companieswithHighestAvgSpeeds','companiesWithMostPenalties','areasWithMostPenalties'));
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

    private function getPieAverageSpeeds($month,$year,$company)
    {
        $bus_companies = Bus_company::leftjoin('buses', 'bus_companies.id', '=', 'buses.bus_company_id')
                ->leftjoin('location_finders', 'buses.id', '=', 'location_finders.bus_id')
                ->leftjoin('locations', 'locations.location_finder_id', '=', 'location_finders.id')
                ->select('company_name as name',DB::raw('AVG(locations.speed) as y'))
                ->groupby('bus_companies.id')
                ->get();


        return $bus_companies;
    }

    private function getLineAverageSpeeds($year,$month,$company_id)
    {
        $bus_companies = Bus_company::leftjoin('buses', 'bus_companies.id', '=', 'buses.bus_company_id')
                ->leftjoin('location_finders', 'buses.id', '=', 'location_finders.bus_id')
                ->leftjoin('locations', 'locations.location_finder_id', '=', 'location_finders.id')
                ->select(DB::raw('AVG(locations.speed) as avg'))
                ->where('bus_companies.id',$company_id)
                ->whereYear('locations.created_at',$year)
                ->whereMonth('locations.created_at',$month)
                ->groupby('bus_companies.id')
                ->first();

        return $bus_companies;
    }

    private function getCompaniesWithHighestAvgSpeed()
    {
        $bus_companies = Bus_company::leftjoin('buses', 'bus_companies.id', '=', 'buses.bus_company_id')
                ->leftjoin('location_finders', 'buses.id', '=', 'location_finders.bus_id')
                ->leftjoin('locations', 'locations.location_finder_id', '=', 'location_finders.id')
                ->select('company_name', DB::raw('AVG(locations.speed) as avg'))
              //  ->whereYear('locations.created_at',$year)
                //->whereMonth('locations.created_at',$month)
                ->groupby('bus_companies.id')
                ->orderby('avg','desc')
                ->take('3')
                ->get();

        return $bus_companies;
    }

    private function getAreasWithMostPenalties()
    {
        $bus_companies = Bus_company::leftjoin('buses', 'bus_companies.id', '=', 'buses.bus_company_id')
                ->leftjoin('location_finders', 'buses.id', '=', 'location_finders.bus_id')
                ->leftjoin('locations', 'locations.location_finder_id', '=', 'location_finders.id')
                ->leftjoin('penalties', 'penalties.location_id', '=', 'locations.id')
                ->select('place',DB::raw('COUNT(penalties.id) as total_penalties'), DB::raw('AVG(locations.speed) as avg'))
              //  ->whereYear('locations.created_at',$year)
                //->whereMonth('locations.created_at',$month)
                ->groupby('penalties.place')
                ->orderby('total_penalties','desc')
                ->orderby('avg','desc')
                ->take('2')
                ->get();

        return $bus_companies;
    }

    private function getCompaniesWithMostPenalties()
    {
        $bus_companies = Bus_company::leftjoin('buses', 'bus_companies.id', '=', 'buses.bus_company_id')
                ->leftjoin('location_finders', 'buses.id', '=', 'location_finders.bus_id')
                ->leftjoin('locations', 'locations.location_finder_id', '=', 'location_finders.id')
                ->leftjoin('penalties', 'penalties.location_id', '=', 'locations.id')
                ->select('company_name',DB::raw('COUNT(penalties.id) as total_penalties'), DB::raw('AVG(locations.speed) as avg'))
              //  ->whereYear('locations.created_at',$year)
                //->whereMonth('locations.created_at',$month)
                ->groupby('bus_companies.id')
                ->orderby('total_penalties','desc')
                ->orderby('avg','desc')
                ->take('3')
                ->get();

        return $bus_companies;
    }

    private function getTotalAverageSpeed(){
       // $av_speed = 
    }

    
}
