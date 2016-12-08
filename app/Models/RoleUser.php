<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    protected $table = 'role_user';

    public function scopePage($query, $page)
    {
        return $query->where('menu_item_id', $page);
    }
}
