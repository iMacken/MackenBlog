<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Input;

class Tag extends Model
{

    protected $fillable = [
        'name',
        'number'
    ];

    public $timestamps = true;

    static $tags;

    /**
     * get the articles associated with the given tag
     * @return [type] [description]
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
