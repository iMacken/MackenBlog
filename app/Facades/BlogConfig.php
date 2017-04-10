<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class BlogConfig extends Facade
{
	public static function getFacadeAccessor()
	{
		return 'BlogConfig';
	}
}