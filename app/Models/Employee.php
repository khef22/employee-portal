<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';

    protected $appends = array('EmploymentStatus');

    public function timeLogs()
    {
    	return $this->hasMany('App\Models\TimeLog', 'emp_id');
    }

    public function supervisorUser()
    {
    	return $this->belongsTo('App\Models\User', 'supervisor_id');
    }

    public function getSupervisorAttribute()
    {
    	return $this->supervisorUser->employee;
    }

    public function getEmploymentStatusAttribute()
    {
    	$result = [
    		'Regular',
    		'Probationary', 
    		'Contractual', 
    		'Finished Contract', 
    		'Resigned', 
    		'Temporary', 
    		'Terminated', 
    		'ON THE JOB TRAINING', 
    		'Trainee'
    	];

    	return (array_key_exists($this->attributes['empstatus'], $result) ? $result[$this->attributes['empstatus']] : "No status added");
    }
}