<?php

namespace App;

use App\Scopes\DraftScope;
use App\Scopes\PublishedScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;


class Article extends Model
{
    use SoftDeletes, Searchable;

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
    protected $fillable = ['user_id', 'category_id', 'title', 'slug', 'image', 'content', 'html_content', 'description', 'is_draft', 'is_original', 'published_at'];

    const INDEX_FIELDS = [
	    'id',
	    'user_id',
	    'category_id',
	    'image',
	    'title',
	    'slug',
	    'description',
	    'is_draft',
	    'is_original',
	    'created_at',
	    'deleted_at',
	    'published_at'
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DraftScope());
	    static::addGlobalScope(new PublishedScope());
    }

    /**
     * Get the user for the blog article.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category for the blog article.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the tags for the blog article.
     *
     * @return \Illuminate\Database\Eloquent\Relations\morphToMany
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * Get the comments for the discussion.
     *
     * @return \Illuminate\Database\Eloquent\Relations\morphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
	
    /**
     * get a list of tag ids associated with the current article
     * @return [array]
     */
    public function getTagListAttribute()
    {
        return $this->tags->pluck('id')->all();
    }

}









