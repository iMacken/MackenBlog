<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
	protected $fillable = ['config'];
	public $timestamps = false;

	public function configurable()
	{
		return $this->morphTo();
	}

	public function getConfigAttribute($meta)
	{
		$meta = json_decode($meta, true);
		return $meta ? $meta : [];
	}

	public function setConfigAttribute($meta)
	{
		$this->attributes['config'] = json_encode($meta);
	}
}
