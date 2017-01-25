<?php

namespace App\Http\Controllers;

use JWTAuth;

use Carbon\Carbon;

use Illuminate\Http\Request;

use Illuminate\Pagination\Paginator;

use App\Models\ScheduleRequest as SR;

class ScheduleRequestsController extends BaseController
{
    public $pageLimit = 15;

    public $currentPage = 1;

    public $orderBy;

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
        $statuses = [
            'all' => 'getAll',
        ];

        $this->pageLimit = $request->input('limit') ? $request->input('limit') : 15;

        $this->orderBy = $request->input('order') ? $request->input('order') : 'date_filed';

        $this->currentPage = $request->input('page') ? $request->input('page') : 1;

        $data = isset($statuses[$request->input('type')]) ? $this->$statuses[$request->input('type')]() : $this->getAll();    	

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

    		$newRecord = new SR();

            $newRecord->emp_id = $this->employee->emp_id;
            $newRecord->change_date_from = Carbon::parse($request->input('change_date_from'));
            $newRecord->request_date_from = Carbon::parse($request->input('request_date_from'));
            $newRecord->p_approver = $this->employee->supervisor_id;
            $newRecord->approval_status = ($this->employee->id == $this->employee->supervisor_id) ? 1 : 0;
            $newRecord->reason_for_changesched = $request->input('reason_for_changesched');
            $newRecord->date_filed = Carbon::now();
            $newRecord->request_start_time = Carbon::parse($request->input('start_hr_cs') . ':' . $request->input('start_min_cs') .' '. $request->input('start_am_cs'));
            $newRecord->request_end_time = Carbon::parse($request->input('end_hr_cs') . ':' . $request->input('end_min_cs') .' '. $request->input('end_am_cs'));
            $newRecord->timezone = $request->input('timezone');

            if ( $newRecord->save() ) {
                $returnData['success'] = true;
                $returnData['id'] = $newRecord->id;
            }

			return response()->json($returnData);

    	} catch ( Exception $e ) {
    		return response()->json($returnData, 500);
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

    private function setDataListOrders()
    {
        if ( isset($this->orderBy) ) {
            return SR::orderBy($this->orderBy, 'DESC');
        }
        
        return SR::orderBy('date_filed', 'DESC');
    }

    private function setPaginateList( $obj )
    {
        $currentPage = $this->currentPage;

        Paginator::currentPageResolver(function() use ($currentPage) {
            return $currentPage;
        });

        return $obj->paginate($this->pageLimit);
    }

    private function getAll()
    {        
        return $this->setPaginateList($this->setDataListOrders());
    }

    private function getApprovedRequests()
    {

    }

    private function getPendingRequests(){}

    private function getDisapprovedRequests(){}

}
