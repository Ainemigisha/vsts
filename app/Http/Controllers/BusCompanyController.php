<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bus_company;
use App\User;
use App\Bus_admin;

class BusCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_companies = Bus_company::with('adminId.user')
            ->orderby('updated_at','desc')
            ->get();

        $admins = User::with('bus_admin.company')
            ->where('category','bus_admin')
            ->orderby('updated_at','desc')
            ->get();

          //  return response()->json($all_companies);

        return view('companies.index',compact('all_companies','admins'));
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
        

        $company = new Bus_company();
        $company->company_name = $request->company_name;
        $company->save();

        $admin = new Bus_admin();
        $admin->id = $request->admin_id;
        $admin->company_id = $company->id;
        $admin->save();

        return redirect('/companies_form');

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

    public function getCompanyList(){
        $companies = Bus_company::all();
        return $companies;
    }
}
