<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Models\TimeLog;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
	protected $employee;

	public function __construct()
	{
		$this->employee = JWTAuth::parseToken()->toUser()->employee()->first();
	}
}
