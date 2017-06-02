<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Toastr extends Facade
{
	public static function getFacadeAccessor()
	{
		return 'Toastr';
	}
}