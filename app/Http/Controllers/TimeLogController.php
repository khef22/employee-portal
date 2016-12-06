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
    		(
    			$this->timeLogCheck(1)->count() 
    			&& $lastDate == Carbon::now()->toDateString()
    		)
    		|| $this->timeLogCheck(4)->isEmpty()
    		&& $this->employee->timeLogs()->get()->count()
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
    		$this->timeLogCheck(2)->count()
    		|| $this->timeLogCheck(4)->count()
    		|| $this->timeLogCheck(1)->isEmpty()
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
    		$this->timeLogCheck(3)->count()
    		|| $this->timeLogCheck(2)->isEmpty()
    		|| $this->timeLogCheck(4)->count()
    		|| $this->timeLogCheck(1)->isEmpty()
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
    		$this->timeLogCheck(4)->count() 
    		|| ( $this->timeLogCheck(2)->count() && $this->timeLogCheck(3)->isEmpty() )
    		|| $this->timeLogCheck(1)->isEmpty() 
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
    	$data = $this->employee->timeLogs()
			->where('date', $lastDate)
			->orderBy('clockin_type', 'desc')
			->first(['clockin_type']);

    	return response()->json(compact('data'));
    }

    private function timeLogCheck($type)
    {
    	$lastDate = $this->employee->timeLogs()->last() ? $this->employee->timeLogs()->last()->date : 'No date to search.';

    	return $this->employee->timeLogs()
			->where('date', $lastDate)
			->where('clockin_type', $type)
			->get();
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
