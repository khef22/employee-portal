<?php

namespace App\Traits;

use App\Models\Common;

trait Common 
{
	public function getEmployeeList( $options = array() )
	{
		return Employee::all();
	}
}

