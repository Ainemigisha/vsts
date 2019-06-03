<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Bus_company;
use App\Penalty;
use App\User;
use Illuminate\Support\Facades\DB;
use Auth;

class PoliceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $line_total_penalties = array();
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $months = ['January'=>'01','February'=>'02','March'=>'03','April'=>'04','May'=>'05','June'=>'06','July'=>'07','August'=>'08','September'=>'09',
                'October'=>'10','November'=>'11','December'=>'12'];
        $companies = Bus_company::all();
        $counter = 0;


        foreach ($companies as $company) {
            $line_total_penalties[$counter]['name'] = $company->company_name;
            foreach ($months as $month_name => $month_val) {
                $line_total_penalties[$counter]['data'][] = (!is_null($this->getLineTotalPenalties($year,$month_val,$company->id))) ? $this->getLineTotalPenalties($year,$month_val,$company->id)->total : 0;                                
            }
            $counter++;
        }   

        $penalties = $this->recentPenalties();

        $pie_total_penalties = $this->getPieTotalPenalties('All',$year);

        $total_penalties = (new PenaltyController())->getTotalPenalties();

        $provisional_total_penalties = (new PenaltyController())->getTotalPenalties(null,"provisional");

        $pending_total_penalties = (new PenaltyController())->getTotalPenalties(null,"pending");

        $cleared_total_penalties = (new PenaltyController())->getTotalPenalties(null,"cleared");

        //return response()->json($penalties);
        return view('police_admin.dashboard',compact('pie_total_penalties','line_total_penalties','months','penalties','total_penalties','provisional_total_penalties','pending_total_penalties','cleared_total_penalties'));
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


    private function getPieTotalPenalties($month,$year)
    {
        $bus_companies = Bus_company::leftjoin('buses', 'bus_companies.id', '=', 'buses.bus_company_id')
                ->leftjoin('location_finders', 'buses.id', '=', 'location_finders.bus_id')
                ->leftjoin('locations', 'locations.location_finder_id', '=', 'location_finders.id')
                ->leftjoin('penalties', 'penalties.location_id', '=', 'locations.id')
                ->select('company_name as name',DB::raw('COUNT(penalties.id) as y'))
                ->groupby('bus_companies.id')
                ->get();


        return $bus_companies;
    }

    private function getLineTotalPenalties($year,$month,$company_id)
    {
        $bus_companies = Bus_company::leftjoin('buses', 'bus_companies.id', '=', 'buses.bus_company_id')
                ->leftjoin('location_finders', 'buses.id', '=', 'location_finders.bus_id')
                ->leftjoin('locations', 'locations.location_finder_id', '=', 'location_finders.id')
                ->leftjoin('penalties', 'penalties.location_id', '=', 'locations.id')
                ->select(DB::raw('COUNT(penalties.id) as total'))
                ->where('bus_companies.id',$company_id)
                ->whereYear('locations.created_at',$year)
                ->whereMonth('locations.created_at',$month)
                ->groupby('bus_companies.id')
                ->first();

        return $bus_companies;
    }

    private function recentPenalties()
    {
        $penalties = Penalty::with('locationFinder.bus.bus_company','assigner.user','clearer.user')
            ->orderBy('created_at','desc')
            ->take('10')
            ->get();

        return $penalties;
    }


    public function verifyLogin(Request $request)
    {   
        //return response()->json(bcrypt($request->password));

        if($this->userAuthentication($request)){
            $police = User::where('name',$request->name)
                ->where('category',"police")
                ->first();

            if (!is_null($police)) {
                return response()->json(["success"=>true,"id"=>$police->id]);
            }else {
                return response()->json(["success"=>false]);
            }
        }else{
            return response()->json(["success"=>false]);
        }

        $police = User::where('name',$request->name)
                ->where('password',bcrypt($request->password))
                ->where('category',"police")
                ->first();
                            
            
   
    }

    public function userAuthentication($request)
    {

        if (Auth::attempt(array('name' => $request->name, 'password' => $request->password))){
            return true;
        }else{
            return false;
        }
        die;
    }
}
