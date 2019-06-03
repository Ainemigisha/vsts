<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Penalty;
use Illuminate\Http\Request;
use App\Police;
use Auth;
use App\Location_finder;
use App\Bus_admin;

class PenaltyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->category == "bus_admin") {
            $company_id = Bus_admin::where('id',Auth::user()->id)
                ->pluck('company_id')
                ->first();  
            $penalties = Penalty::with('locationFinder.bus.bus_company','assigner.user','clearer.user')
                ->whereHas('locationFinder.bus.bus_company', function($query) use ($company_id) {
                    $query->where('id',$company_id);
                })
                ->orderBy('created_at','desc')
                ->get();
        }else{
            $penalties = Penalty::with('locationFinder.bus.bus_company','assigner.user','clearer.user')
                
                ->orderBy('created_at','desc')
                ->get();
        }

        
     
         
        return view('penalties.index',compact('penalties'));
    }

    public function clear(Request $request)
    {
        $penalty = Penalty::find($request->penalty_id);

        $penalty->status = "Cleared";
        $penalty->cleared_by = Auth::user()->id;
        $penalty->cleared_date = Carbon::now();
        $penalty->save();
        
        return redirect('/penalties');
    }

    public function reject(Request $request)
    {
        $penalty = Penalty::find($request->penalty_id);

        $penalty->status = "Rejected";
        $penalty->cleared_by = Auth::user()->id;
        $penalty->cleared_date = Carbon::now();
        $penalty->save();
        
        return redirect('/penalties');
    }

    public function api_assign_penalty(Request $request)
    {

        /*$pen = Penalty::create([
            'location_finder_id'=>$request->location_finder_id,
            'location_id'=>$request->location_id,
            'latitude'=>$request->latitude,
            'longitude'=>$request->longitude,
            'assigned_by'=>$request->assigner_id,
            'status'=>$request->status,
            'speed'=>$request->speed,
            'place'=>$request->place
            
        ]);*/

        $penalties = Penalty::where('location_finder_id',$request->location_finder_id)
                ->where('status','Provisional')
                ->orderby('created_at','desc')
                ->get();

        $penalty = $penalties[0];
        $penalty->status = 'pending';
        $penalty->assigned_by = $request->assigner_id;
        $penalty->place = $request->place;
        $penalty->assigned_date = Carbon::now();
        $penalty->save();

        if (count($penalties) == 1) {
            $finder = Location_finder::find($request->location_finder_id);
            $finder->flag = 0;
            $finder->save();
        }

        if ($penalty->place != null) {
            return response()->json(["message"=>"Penalty Assigned","success"=>true]);
        }else{
            return response()->json(["message"=>"Ooops! Something wemt wrong.","success"=>false]);
        }
        
       // return response()->json($request);
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
     * @param  \App\Penalty  $penalty
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $penalty = Penalty::with('locationFinder.bus.bus_company','assigner.user','clearer.user')
                ->where('id',$id)
                ->orderBy('created_at','desc')
                ->first();

        $other_penalties = Penalty::with('locationFinder.bus.bus_company','assigner.user','clearer.user')
                ->whereHas('locationFinder.bus', function($query) use ($penalty) {
		            $query->where('number_plate',$penalty->locationFinder->bus->number_plate);
                })
                ->where('id','!=',$id)
                ->orderBy('created_at','desc')
                ->get();
        //return response()->json($other_penalties);
        return view('penalties.show',compact('penalty','other_penalties'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Penalty  $penalty
     * @return \Illuminate\Http\Response
     */
    public function edit(Penalty $penalty)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Penalty  $penalty
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Penalty $penalty)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Penalty  $penalty
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penalty $penalty)
    {
        //
    }

    public function api_get_penalties(Request $request)
    {
        //return response()->json($request->id);
        $penalty = Penalty::with('locationFinder.bus.bus_company','assigner.user','clearer.user')
            ->whereHas('assigner.user', function($query) use ($request) {
		        $query->where('id',$request->id);
	        })
            ->orderby('created_at','desc')
            ->get();

        return response()->json($penalty);

    }

    public function api_get_provisional_penalty(Request $request)
    {
        $penalty = Penalty::where('location_finder_id',$request->id)
                ->where('status','provisional')
                ->first();

        return response()->json($penalty);

    }

    public function getTotalPenalties($company_id = null, $status = null)
    {
        
        if ($company_id == null) {
            if ($status == null) {
                $totalPenalties = Penalty::count('id');
            }else{
                $totalPenalties = Penalty::where('status',$status)
                    ->count('id');
            }
        }else{
            $totalPenalties = Penalty::with('locationFinder.bus.bus_company')
                    ->whereHas('locationFinder.bus.bus_company', function($query) use ($company_id) {
                        $query->where('id',$company_id);
                    })
                    ->count('id');
        
        }
       
       return $totalPenalties;
    }
}
