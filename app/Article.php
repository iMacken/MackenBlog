<?php

namespace App;

use App\Scopes\DraftScope;
use App\Scopes\PublishedScope;
use App\Services\Markdowner;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Elasticquent\ElasticquentTrait;

class Article extends Model
{
    use SoftDeletes, ElasticquentTrait;

    protected $mappingProperties = array(
       'title' => array(
            'type' => 'string',
            'analyzer' => 'ik_max_word'
        ),
       'content' => array(
            'type' => 'string',
            'analyzer' => 'ik_max_word'
        )
    );

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
    protected $fillable = ['user_id', 'category_id', 'title', 'slug', 'image', 'content', 'description', 'is_draft', 'is_original', 'published_at'];

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
     * Get the config for the configuration.
     *
     * @return \Illuminate\Database\Eloquent\Relations\morphMany
     */
    public function config()
    {
        return $this->morphMany(Configuration::class, 'configuration');
    }

    /**
     * get a list of tag ids associated with the current article
     * @return [array]
     */
    public function getTagListAttribute()
    {
        return $this->tags->pluck('id')->all();
    }

    /**
     * Set the title and the readable slug.
     *
     * @param string $value
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;

        if (!config('services.youdao.key') || !config('services.youdao.from')) {
            $this->setUniqueSlug($value, '');
        } else {
            $this->attributes['slug'] = translug($value);
        }
    }

    /**
     * Set the unique slug.
     *
     * @param $value
     * @param $extra
     */
    public function setUniqueSlug($value, $extra) {
        $slug = str_slug($value.'-'.$extra);
        if (static::whereSlug($slug)->exists()) {
            $this->setUniqueSlug($slug, $extra+1);
            return;
        }
        $this->attributes['slug'] = $slug;
    }

    /**
     * Set the content attribute.
     *
     * @param $value
     */
    public function setContentAttribute($value)
    {
        $data = [
            'raw'  => $value,
            'html' => (new Markdowner)->convertMarkdownToHtml($value)
        ];

        $this->attributes['content'] = json_encode($data);
    }

    /**
     * get articles associated with the given keyword in elasticsearch index
     * @param $keyword
     * @return mixed
     */
    public static function searchIndex($keyword)
    {
        try {
            $query = ['filtered' => [
                'filter' => ['range' => ['category_id' => ['gt' => 0]]],
                'query'  => [
                    ['multi_match'=>[
                        'query' => $keyword,
                        'fields'=>['title', 'content']]
                    ],
                ],
            ]];
            $fields = ['id','title','slug','content','created_at','category_id'];

            $perPage = 8;
            $page = \Request::input('page');
            !$page && $page = 1;
            $offset = ($page - 1) * $perPage;
            return self::searchByQuery($query, null, $fields, $perPage, $offset)->paginate($perPage);
        } catch (Exception $e) {
            return false;
        }
    }
}









