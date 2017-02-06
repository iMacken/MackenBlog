<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{

    use SoftDeletes;

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
    protected $fillable = [
        'tag', 'title', 'subtitle', 'meta_description'
    ];

	/**
	 * Get all of the articles that are assigned this tag.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\MorpheByMany
	 */
	public function articles()
	{
		return $this->morphedByMany(Article::class, 'taggable');
	}

    /**
     * get tag model
     * @param $id
     * @return mixed
     */
    public static function getTagModel($id)
    {
        if (is_numeric($id)) {
            return self::findOrFail($id);
        } else {
            return self::where('name', '=', $id)->first();
        }

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
     * 根据标签id串获取标签数据
     * @param string $tagIds
     * @return \Illuminate\Support\Collection|null|static
     */
    public static function getTagModelByTagIds($tagIds)
    {
        $tags = explode(',', $tagIds);
        return !empty($tags) ? self::find($tags) : null;

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
