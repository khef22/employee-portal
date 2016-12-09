<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ScheduleRequest extends Model
{
    protected $table = 'shift_scheds_logs';

    protected $guarded = ['id'];

    protected $fillable = ['first_name', 'last_name', 'email'];
    
}
