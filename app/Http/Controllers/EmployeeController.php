<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class EmployeeController extends BaseController
{
    public function profile()
    {
    	$employee = [];

    	$datestart = Carbon::createFromFormat('Y-m-d', $this->employee->datestart);
    	$datefinish = Carbon::createFromFormat('Y-m-d', $this->employee->datefinish);

    	$employee['nickname'] = $this->employee->nickname;
    	$employee['employeeId'] = $this->employee->employee_id;
    	$employee['department'] = $this->user->vwUserEmployee->department;
    	$employee['datestart'] = $datestart->toDateTimeString();
    	$employee['datefinish'] = !$datestart->gt($datefinish) ? $datefinish->toDateTimeString() : false;
    	$employee['position'] = $this->user->vwUserEmployee->title;
    	$employee['client'] = $this->user->vwUserEmployee->client_names;
    	$employee['hrTitle'] = $this->employee->hrtitle;
    	$employee['mobile'] = $this->employee->telephone01;
    	$employee['email'] = $this->employee->email;
    	$employee['sss'] = $this->employee->sss;
    	$employee['philhealth'] = $this->employee->philhealth;
    	$employee['pagibig'] = $this->employee->supervisor->firstname . $this->employee->supervisor->lastname;
    	$employee['seatAssign'] = $this->user->listFloorPlan->floorplan_name ." R ". $this->user->floorPlan->row_number."-". $this->user->floorPlan->seat_number;
    	$employee['isSalesRep'] = $this->employee->issalesrep;
    	$employee['isRecruiter'] = $this->employee->isrecruiter;

    	return $employee;
    }
}
