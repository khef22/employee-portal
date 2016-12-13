<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
    protected $table = 'purchaserequest';


    public function getTypeAttribute($value)
    {
        if($value == 1)
        {
			return "Budgeted";
		}
		elseif($value == 2)
		{
			return "Non-Budgeted";
		}
		else{
			return "";
		}
    } 

    public function getDepartmentAttribute($value)
    {
        if($value == "Corporate")
        {
			return "Executive";
		}
		else{
			return $value;
		}
    }

    public function getTotalAttribute($value)
    {
        return number_format($value,2,'.',',');
    }

    public function getDateAttribute($value)
    {
        return date('m/d/Y',strtotime($value));
    }

    public function getApprovalStatusAttribute($value)
    {
        if($value == 0){
			return "";
		}
		elseif($value == 1) {
			return "Approved";
		}
		elseif($value == 2){
			return "";
		}
		elseif($value == 6){
			return "Void";
		}
    }

    public function requestor()
    {
        return $this->belongsTo('App\Models\Employee','user_id','user_id');
    }
}