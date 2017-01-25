<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FpStation extends Model
{
    protected $table = 'fp_stations';

    public function listFloorplan()
    {
    	return $this->belongsTo('App\Models\ListFloorplan', 'fp_id');
    }
}
