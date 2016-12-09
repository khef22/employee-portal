<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'AngularController@serveApp');

Route::get('/unsupported-browser', 'AngularController@unsupported');

Route::get('/test', function() {

	$s = App\Models\Employee::whereHas('empPositionHistory', 
	function($q){
		$q->where('sup_flag', 1)
		  ->where('status', 1);
	})
	->whereYear('datefinish', "<", 1000)
	->get();

	// dd(App\Models\User::supervisors()->get());

	return App\Models\User::with('employee')->supervisors()->get();

	$eph = App\Models\EmpPositionHist::supervisors()->get();

	dd($eph);
	return $eph;
});