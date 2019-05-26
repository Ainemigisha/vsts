<?php
use App\Http\Controllers\BusController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|


/*
Route::get('/police_admin', function (){

    return view('police_admin.dashboard');
}); */

Route::get('/', 'PublicController@index');

Auth::routes();


Route::get('/speeds', function (){
    return view('police_admin.speeds');
});


Route::get('/bus_admin', function (){

    return view('bus_admin.dashboard');
});

Route::get('/bus_admin', 'BusAdminController@index');

/*Route::get('/system_admin', function (){
    return view('system_admin.dashboard');
});*/



Route::get('/public','PublicController@index')->name('home');

Route::get('speed','LocationController@getTotalAverageSpeed');



Route::get('/location_finders', 'LocationFinderController@index');

Route::post('/add_location_finder','LocationFinderController@store');


Route::get('/devices', 'DeviceController@index');

Route::post('/add_device','DeviceController@store');



Route::get('/bus_details/{id}', 'BusController@show');

Route::get('/bus_details_form', 'BusController@create');

Route::post('/add_bus','BusController@store');

Route::get('/buses','BusController@index');



Route::get('/speeds','LocationController@get_daily_average_speed');

//Route::get('/police_admin', 'LocationController@index');

Route::get('/police_admin', 'PoliceController@index');



Route::post('/api/locations','LocationController@api_get_locations');

Route::post('/api/location','LocationController@store');




Route::post('/api/penalty_assign','PenaltyController@api_assign_penalty');

Route::post('/api/penalties','PenaltyController@api_get_penalties');

Route::post('/api/verifyLogin','PoliceController@verifyLogin');



Route::get('/penalties','PenaltyController@index');

Route::post('/penalty_clear','PenaltyController@clear');


Route::get('/live_feed', function (){
    return view('bus_admin.live_feed');
});


Route::get('/xml_feed', 'LocationController@displayGrid')->name('xml_feed');



Route::get('/logout', function ()
{
    Auth::logout();
    return redirect('/public');
});
