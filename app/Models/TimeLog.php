<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TimeLog extends Model
{
	const CREATED_AT = 'time';

	public $timestamps = false;

    protected $table = 'time_logs';

    protected static function boot()
    {
        parent::boot();
        static::creating( function ($model) {
	        $model->setCreatedAt($model->freshTimestamp());
	    });
    }

    public function scopeLast($query)
    {
    	return $query->orderBy('id', 'desc')->first();
    }

    public function scopeGetTodaysBreakIn($query)
    {
    	$today = \Carbon\Carbon::now()->toDateString();
    	return $query->where('date', $today);
    }

    public function scopeGetAllClockIn($query)
    {
    	return $query->where('clockin_type', 1);
    }
}
