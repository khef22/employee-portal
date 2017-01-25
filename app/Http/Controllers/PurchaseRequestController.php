<?php

namespace App\Http\Controllers;

use App\Models\PurchaseRequest as PR;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class PurchaseRequestController extends BaseController
{
    public function purchaseRequestList(Request $request, $status = "waiting-for-my-approval")
    {
    	$error = false;

        $this->page = $request->input('page');
        $this->limit = $request->input('limit');

    	$_status = array(
    		'waiting-for-approval' => 'listWaitingForApproval',
    		'waiting-for-my-approval' => 'listWaitingForMyApproval',
    		'my-approval-history' => 'listMyApprovalHistory',
    		'approved' => 'listApproved',
    		'disapproved' => 'listDisapproved',
    		'void' => 'listVoid',
    		'billable-to-client' => 'listBillableToClient',
    		'all' => 'listAll',
    	);

    	if(
    		$purcahseRequestsList = (isset($_status[$status])) ? $this->$_status[$status]() : $this->$_status['waiting-for-my-approval']()
    	)
    	{
    		return response()->json(compact("purcahseRequestsList"));
    	}

    	return response()->error('Something is not right!', 403);
    }

    private function listWaitingForApproval()
    {
    	return false;
    }

    private function listWaitingForMyApproval()
    {
        $currentPage = $this->page;
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });

        return PR::with('requestor')->orderBy('id','desc')->paginate($this->limit);

    	return false;
    }

    private function listMyApprovalHistory()
    {
    	return false;
    }

    private function listApproved()
    {
    	return false;
    }

    private function listDisapproved()
    {
    	return false;
    }

    private function listVoid()
    {
    	return false;
    }

    private function listBillableToClient()
    {
    	return false;
    }

    private function listAll()
    {
    	return false;
    }
}
