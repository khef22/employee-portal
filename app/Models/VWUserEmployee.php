<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VWUserEmployee extends Model
{
    protected $table = "vw_user_employee";
    public $timestamps = false;

    protected $fillable = [
        'department', 'title', 'client_names',
    ];
}
