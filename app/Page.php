<?php

namespace App;

use App\Scopes\PublishedScope;
use App\Traits\Commentable;
use App\Traits\Configurable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Page extends Model
{
    use SoftDeletes, Searchable, Configurable, Commentable;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['published_at', 'created_at', 'deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = ['slug', 'title', 'content', 'html_content', 'published_at'];

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(new PublishedScope());
    }

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
