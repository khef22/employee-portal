<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    public $timestamps = false;
    protected $table = 'position';

    protected $fillable = ['title'];

    public function department()
    {
    	return $this->belongsTo('App\Models\Department', 'department_id', 'department_id');
    }

    public function contract()
    {
    	return $this->belongsTo('App\Models\Contract', 'contracts_id');
    }
}