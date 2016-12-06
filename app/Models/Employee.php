<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';

    public function timeLogs()
    {
    	return $this->hasMany('App\Models\TimeLog', 'emp_id');
    }
}