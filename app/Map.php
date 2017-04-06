<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
	public $timestamps = false;

	protected $fillable = ['key','value'];
}