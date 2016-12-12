<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Models\TimeLog;
use Illuminate\Http\Request;

class BaseController extends Controller
{
	protected $employee;
	protected $user;	

	public function __construct( $modelName = null )
	{
		$this->user = JWTAuth::parseToken()->toUser();
		$this->employee = JWTAuth::parseToken()->toUser()->employee()->first();		
	}

}

