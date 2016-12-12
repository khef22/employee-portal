<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EmployeeController extends BaseController
{
    public function profileField()
    {
    	$employee = [];

    	$datestart = Carbon::createFromFormat('Y-m-d', $this->employee->datestart);
    	$datefinish = Carbon::createFromFormat('Y-m-d', $this->employee->datefinish);

    	$employee['nickname'] = $this->employee->nickname;
    	$employee['employeeId'] = $this->employee->employee_id;
        $employee['mobile'] = $this->employee->telephone01;
        $employee['hrTitle'] = $this->employee->hrtitle;
        $employee['philhealth'] = $this->employee->philhealth;
        $employee['pagibig'] = $this->employee->pagibig;
        $employee['tin'] = $this->employee->tin;
        $employee['sss'] = $this->employee->sss;
        $employee['manager'] = $this->employee->supervisor->id;
        $employee['isSalesRep'] = $this->employee->issalesrep;
        $employee['isRecruiter'] = $this->employee->isrecruiter;
        $employee['employee_status'] = $this->employee->empstatus;
        $employee['datepickerstart'] = $datestart->toDateTimeString();
        $employee['datepickerfinish'] = !$datestart->gt($datefinish) ? $datefinish->toDateTimeString() : false;

        $employee['email'] = $this->user->email;
    	$employee['department'] = $this->user->department()->dept_name;
        $employee['position'] = $this->user->position()->title;
        // $employee['client'] = $this->user->client()->client_name;
        $employee['seatAssign'] = $this->user->listFloorPlan->floorplan_name ." R ". $this->user->floorPlan->row_number."-". $this->user->floorPlan->seat_number;

    	return response()->json($employee);
    }

    public function profilePage()
    {
    	$options = [];

        $options['supervisors'] = Employee::supervisors()->get();
    	$options['employee_statuses'] = ['Regular', 'Probationary', 'Contractual', 'Finished Contract', 'Resigned', 'Temporary', 'Terminated', 'ON THE JOB TRAINING', 'Trainee'];

        return response()->json($options);
    }

    public function profileSave(Request $request)
    {
        $request = $request->only([
            "nickname", "datestart", "datefinish", "position", "client", 
            "hrTitle", "mobile", "email", "sss", "philhealth", "pagibig", 
            "tin", "manager", "seatAssign", "isSalesRep", "isRecruiter", 
            "employee_status", "position", "client",
        ]);

        $this->employee->nickname = $request['nickname'];

        if($request['datestart']) {
            $this->employee->datestart = Carbon::parse($request['datestart']);
        }

        if($request['datefinish']){
            $this->employee->datefinish = Carbon::parse($request['datefinish']);
        }

        $this->employee->hrtitle = $request['hrTitle'];
        $this->employee->philhealth = $request['philhealth'];
        $this->employee->pagibig = $request['pagibig'];
        $this->employee->tin = $request['tin'];
        $this->employee->sss = $request['sss'];
        $this->employee->supervisor_id = $request['manager'];
        $this->employee->issalesrep = $request['isSalesRep'];
        $this->employee->isrecruiter = $request['isRecruiter'];
        $this->employee->telephone01 = $request['mobile'];

        $this->employee->save();

        $this->user->email = $request['email'];
        $empPos = $this->user->position();
        $empPos->title = $request['position'];

        $this->user->save();
        $empPos->save();

        return response()->json("success");
    }
}
