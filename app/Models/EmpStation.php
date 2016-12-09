<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpStation extends Model
{
    protected $table = 'emp_station';

    public function fpStation()
    {
    	return $this->belongsTo('App\Models\FpStation', 'emp_fps_id', 'fps_id');
    }
}
