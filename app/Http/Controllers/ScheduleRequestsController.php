<?php

namespace App\Http\Controllers;

use JWTAuth;

use Illuminate\Http\Request;

use App\Models\ScheduleRequest;

class ScheduleRequestsController extends BaseController
{
    public function __construct()
    {
    	parent::__construct();
    }

    public function index(){}

    /**
    * Fetch Schedule Request List
    *
    * @param Object $request Request
    *
    * @return object
    **/
    public function getList( Request $request )
    {
    	$data = $this->employee->scheduleRequests()
    		->orderBy('date_filed', 'DESC')
    		// ->limit($request->input('limit', 10))
    		->paginate($request->input('limit', 10));
    		// ->get();

    	return response()->json(compact('data'), 200);
    }

    /**
    * Add/Update Schedule Request Record
    *
    * @param Object $request Request
    *
    * @return json $data
    **/
    public function addRequest( Request $request )
    {
    	$returnData = array('success' => false, 'id' => 0);

    	try {

    		$newRecord = new App\Models\ScheduleRequest();

    		// to be continued here tomorrow


			return response()->json(compact('returnData'));

    	} catch ( Exception $e ) {
    		return response()->json(compact('returnData'), 500);
    	}
    	
    }

    /**
    * Remove Schedule Request Record via $recordId
    *
    * @param int $recordId
    * 
    * @return json $data
    **/
    public function removeRequest( $recordId )
    {
    	$returnData = array('success' => false, 'id' => $recordId);

    	try {

	    	if ( $recordId > 0 && !empty($recordId) ) {

	    		$removeRecord = $this->employee->scheduleRequests()->find($recordId);

	    		if ( $removeRecord ) {
	    			$removeRecord->delete();	
	    			$returnData['success'] = true;
	    		} 

	    	}

			return response()->json(compact('returnData'));

    	} catch ( Exception $e ) {
    		return response()->json(compact('returnData'), 500);
    	}

    }


}
