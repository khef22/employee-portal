<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use App\Traits\Common;

use Illuminate\Pagination\Paginator;

use App\Models\Announcement as AN;


class AnnouncementsController extends BaseController
{
	// use Common; 

 	public $pageLimit = 15;

  public $currentPage = 1;

  public $orderBy;	

 	public function getList( Request $request )
 	{
 		  $statuses = [
            'all' => 'getAll',
        ];

      $this->pageLimit = $request->input('limit') ? $request->input('limit') : 15;

      $this->orderBy = $request->input('order') ? $request->input('order') : 'created_at';

      $this->currentPage = $request->input('page') ? $request->input('page') : 1;

      $data = isset($statuses[$request->input('type')]) ? $this->$statuses[$request->input('type')]() : $this->getAll();    	

      return response()->json(compact('data'), 200);

 	}

 	private function setDataListOrders()
  {
      return AN::with(['employee' => function($q){ $q->orderBy('id', 'DESC');}])->orderBy('created_at','DESC'); 
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


}
