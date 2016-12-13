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
    	$employee['department'] = $this->user->currentDepartment->dept_name;
        $employee['position'] = $this->user->currentPosition->title;
        $employee['client'] = $this->user->currentClient->client_name;
        $employee['seatAssign'] = $this->user->listFloorPlan->floorplan_name ." R ". $this->user->floorPlan->row_number."-". $this->user->floorPlan->seat_number;

    	return response()->json($employee);
    }

    public function profilePage()
    {
    	$options = [];

        $options['supervisors'] = Employee::getSupervisors()->get(['id', 'firstname', 'lastname']);
    	$options['employee_statuses'] = ['Regular', 'Probationary', 'Contractual', 'Finished Contract', 'Resigned', 'Temporary', 'Terminated', 'ON THE JOB TRAINING', 'Trainee'];

        // $employee = [];

        // $datestart = Carbon::createFromFormat('Y-m-d', $this->employee->datestart);
        // $datefinish = Carbon::createFromFormat('Y-m-d', $this->employee->datefinish);

        // $employee['nickname'] = $this->employee->nickname;
        // $employee['employeeId'] = $this->employee->employee_id;
        // $employee['mobile'] = $this->employee->telephone01;
        // $employee['hrTitle'] = $this->employee->hrtitle;
        // $employee['philhealth'] = $this->employee->philhealth;
        // $employee['pagibig'] = $this->employee->pagibig;
        // $employee['tin'] = $this->employee->tin;
        // $employee['sss'] = $this->employee->sss;
        // $employee['manager'] = $this->employee->supervisor->id;
        // $employee['isSalesRep'] = $this->employee->issalesrep;
        // $employee['isRecruiter'] = $this->employee->isrecruiter;
        // $employee['employee_status'] = $this->employee->empstatus;
        // $employee['datepickerstart'] = $datestart->toDateTimeString();
        // $employee['datepickerfinish'] = !$datestart->gt($datefinish) ? $datefinish->toDateTimeString() : false;

        // $employee['email'] = $this->user->email;
        // $employee['department'] = $this->user->currentDepartment->dept_name;
        // $employee['position'] = $this->user->currentPosition->title;
        // $employee['client'] = $this->user->currentClient->client_name;
        // $employee['seatAssign'] = $this->user->listFloorPlan->floorplan_name ." R ". $this->user->floorPlan->row_number."-". $this->user->floorPlan->seat_number;

        return response()->json($options);
    }

    public function profileSave(Request $request)
    {
        $user = $request->only([
            "email",
            "position",
        ]);

        $employee = $request->only([
            "nickname", "hrTitle", "philhealth", "pagibig", "tin", "sss", "manager", "isSalesRep", "isRecruiter", "mobile", "datestart", "datefinish", ]);

        $this->employee->nickname = $employee['nickname'];

        if($employee['datestart']) {
            $this->employee->datestart = Carbon::parse($employee['datestart']);
        }

        if($employee['datefinish']){
            $this->employee->datefinish = Carbon::parse($employee['datefinish']);
        }

        $this->employee->hrtitle = $employee['hrTitle'];
        $this->employee->philhealth = $employee['philhealth'];
        $this->employee->pagibig = $employee['pagibig'];
        $this->employee->tin = $employee['tin'];
        $this->employee->sss = $employee['sss'];
        $this->employee->supervisor_id = $employee['manager'];
        $this->employee->issalesrep = $employee['isSalesRep'];
        $this->employee->isrecruiter = $employee['isRecruiter'];
        $this->employee->telephone01 = $employee['mobile'];

        $this->employee->save();

        $this->user->email = $user['email'];
        $empPos = $this->user->currentPosition;
        $empPos->title = $user['position'];

        $this->user->save();
        $empPos->save();

        return response()->json("success");
    }
}
