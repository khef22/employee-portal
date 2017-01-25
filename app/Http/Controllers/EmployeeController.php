<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EmployeeController extends BaseController
{
    public function profile()
    {
        $employee = $this->employee->setVisible(['nickname', 'address01', 'address02', 'secondaryemail', 'telephone01', 'telephone02', 'emergency_contact_name', 'emergency_contact_no', 'emergency_contact_relationship']);

        return response()->json($employee);
    }

    public function profileSave(Request $request)
    {
        $employee = $request->only(['nickname', 'address01', 'address02', 'secondaryemail', 'telephone01', 'telephone02', 'emergency_contact_name', 'emergency_contact_no', 'emergency_contact_relationship']);

        $this->employee->update($employee);

        return response()->json("success");
    }
}
