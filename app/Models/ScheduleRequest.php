<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ScheduleRequest extends Model
{
    protected $table = 'shift_scheds_logs';

    protected $guarded = ['id', 'emp_id'];

    protected $fillable = [
    	'change_date_from', 
    	'request_date_from', 
    	'p_approver', 's_approver', 
    	'approval_status', 
    	'reason_for_changesched', 
    	'date_filed', 
    	'request_start_time',
    	'request_end_time',
    	'date_approve',
    	'timezone',
    	'approved_by',
    	'change_date_to',
    	'request_date_to' ];
    
}
