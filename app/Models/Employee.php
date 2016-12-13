<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public $timestamps = false;
    protected $table = 'employees';
    protected $fillable = [
    	'nickname', 'hrtitle', 'philhealth', 'pagibig', 'tin', 'sss',
    	'supervisor_id', 'issalesrep', 'isrecruiter', 'empstatus', 'telephone01',
    	'datestart', 'datefinish'
    ];

    public function timeLogs()
    {
    	return $this->hasMany('App\Models\TimeLog', 'emp_id');
    }

    public function scheduleRequests()
    {
        return $this->hasMany('App\Models\ScheduleRequest', 'emp_id');
    }

    public function supervisorUser()
    {
    	return $this->belongsTo('App\Models\Employee', 'supervisor_id');
    }

    public function getSupervisorAttribute()
    {
    	return $this->supervisorUser;
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

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function scopeGetSupervisors($query)
    {
        return $query->whereHas('user.empPositionHistory', function($q){
                $q->where('sup_flag', 1)
                  ->where('status', 1);
            })
            ->whereYear('datefinish', "<", 1000);
    }
}