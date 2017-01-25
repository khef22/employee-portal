<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $table = 'announcements';

    public function employee()
    {
    	return $this->belongsTo('App\Models\Employee', 'emp_id');
    }
    
}
