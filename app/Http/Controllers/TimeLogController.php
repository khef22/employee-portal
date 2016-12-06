<?php

namespace App\Http\Controllers;

use JWTAuth;
use Carbon\Carbon;
use App\Models\TimeLog;
use Illuminate\Http\Request;

class TimeLogController extends EmployeeController
{
    public function clockIn()
    {
    	$lastDate = $this->employee->timeLogs()->last() ? $this->employee->timeLogs()->last()->date : 'No date to search.';
    	$error = false;

    	if(
    		$this->timeLogLastClockType() != 4
    	)
    	{
    		$error = true;
    		return response()->json(compact("error"), 400);
    	}

    	$this->timeLogSave(1);

    	return response()->json(compact("error"));
    }

    public function breakIn()
    {
    	$error = false;

    	if(
    		$this->timeLogLastClockType() == 2
    		|| $this->timeLogLastClockType() == 4
    	)
    	{
    		$error = true;
    		return response()->json(compact("error"), 400);
    	}

    	$this->timeLogSave(2);

    	return response()->json(compact("error"));
    }

    public function breakOut()
    {
    	$error = false;

    	if(
    		$this->timeLogLastClockType() != 2
    	)
    	{
    		$error = true;
    		return response()->json(compact("error"), 400);
    	}

    	$this->timeLogSave(3);

    	return response()->json(compact("error"));
    }

    public function clockOut()
    {
    	$error = false;
    	if(
    		$this->timeLogLastClockType() == 2
    		|| $this->timeLogLastClockType() == 4
    	)
    	{
    		$error = true;
    		return response()->json(compact("error"), 400);
    	}

    	$this->timeLogSave(4, true);

    	return response()->json(compact("error"));
    }

    public function timeLogStatus()
    {
    	$lastDate = $this->employee->timeLogs()->last() ? $this->employee->timeLogs()->last()->date : 'No date to search.';
    	$clockinTypes = $this->timeLogLastClockType();

    	return response()->json(compact('clockinTypes', 'lastDate'));
    }

    private function timeLogLastClockType()
    {
    	$lastDate = $this->employee->timeLogs()->last() ? $this->employee->timeLogs()->last()->date : 'No date to search.';
    	$clockinType = $this->employee->timeLogs()
			->where('date', $lastDate)
			->orderBy('id', 'desc')
			->first();

    	return $clockinType ? $clockinType->clockin_type : 0;
    }

    private function timeLogSave($type, $clockOut = false)
    {
    	$timeLog = new TimeLog;
    	$timeLog->clockin_type = $type;

    	if($clockOut)
    	{
	    	$timeLog->date = Carbon::parse($this->employee->timeLogs()->last()->date)->toDateString();
    	}
    	else
    	{
    		$timeLog->date = Carbon::now()->toDateString();
    	}

    	$this->employee->timeLogs()->save($timeLog);
    }
}
