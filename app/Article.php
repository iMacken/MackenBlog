<?php

namespace App;

use App\Scopes\PublishedScope;
use App\Traits\Commentable;
use App\Traits\Configurable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;


class Article extends Model
{
    use SoftDeletes, Searchable, Configurable, Commentable;

	const PAGE_LIMIT = 7;

	public function toSearchableArray()
	{
		return [
			'title' => $this->title,
			'content' => $this->content
		];
	}

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
    protected $fillable = ['user_id', 'category_id', 'title', 'slug', 'image', 'content', 'html_content', 'excerpt', 'published_at'];

    const INDEX_FIELDS = [
	    'id',
	    'user_id',
	    'category_id',
	    'image',
	    'title',
	    'slug',
	    'excerpt',
	    'created_at',
	    'deleted_at',
	    'published_at'
    ];

    public static function boot()
    {
        parent::boot();
        static::addGlobalScope(new PublishedScope());
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function getTagListAttribute()
    {
        return $this->tags->pluck('id')->all();
    }

    public function scopePublished($query)
    {

    }

    public function configuration()
    {
        return $this->morphOne(Configuration::class, 'configurable');
    }

	public function getConfigKeys()
	{
		return ['if_allow_comment', 'if_show_comments', 'is_draft', 'is_original'];
	}

}









