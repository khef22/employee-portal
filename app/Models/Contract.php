<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $table = 'contracts';

    public function client()
    {
    	return $this->belongsTo('App\Models\Client', 'client_id');
    }
}
