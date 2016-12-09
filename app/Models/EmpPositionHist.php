<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpPositionHist extends Model
{
    protected $table = "emp_posn_hist";

    public function employee()
    {
    	return $this->belongsTo('App\Models\Employee', 'emp_id');
    }

    public function employeePosition()
    {
    	return $this->belongsTo('App\Models\Position', 'position');
    }

    public function scopeSupervisors($query)
    {
    	return $query->whereHas('employee', function($q){
				$q->whereYear('datefinish', "<", 1000);
			})
			->where('sup_flag', 1)
			->where('status', 1);
    }
}
