<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
	protected $fillable = ['name', 'display_name', 'content', 'html_content'];

	public function comments()
	{
		return $this->morphMany(Comment::class, 'commentable');
	}
}
