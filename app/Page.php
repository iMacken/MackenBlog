<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
	protected $fillable = ['slug', 'title', 'content', 'html_content'];

	public function comments()
	{
		return $this->morphMany(Comment::class, 'commentable');
	}

    public function configuration()
    {
        return $this->morphOne(Configuration::class, 'configurable');
    }

    public function getConfigKeys()
    {
        return ['if_allow_comment', 'if_show_comments', 'is_draft'];
    }
}
