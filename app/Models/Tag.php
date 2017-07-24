<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{

    use SoftDeletes;

	const PAGE_LIMIT = 7;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug'];

	/**
	 * Get all of the posts that are assigned this tag.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
	 */
	public function posts()
	{
		return $this->morphedByMany(Post::class, 'taggable');
	}

    /**
     * get all tags
     * @return mixed
     */
    public static function getTagList()
    {
        return self::all()->toArray();
    }

    /**
     * 根据tagId 获取 tagName
     * @param $tagId
     * @return string
     */
    public static function getTagNameByTagId($tagId){
        if(!isset(self::$tags[$tagId])){
            $tag = self::find($tagId);
            if(!empty($tag)){
                self::$tags[$tag->id] = $tag->name;
            }
        }
        return isset(self::$tags[$tagId])?self::$tags[$tagId]:'';
    }

    /**
     * get hot tags
     * @param $limit
     * @return mixed
     */
    public static function getHotTags($limit)
    {
        return self::orderBy('number', 'DESC')->limit($limit)->get();
    }

}
