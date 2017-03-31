<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Input;

class Category extends Model
{
    const PAGE_LIMIT = 7;

    protected $fillable = [
        'name',
        'slug',
	    'description',
	    'order'
    ];

    static $categoryData = [
        0 => '顶级分类',
    ];

    static $category = [];

    public $html;

    public function articles()
    {
        return $this->hasMany('App\Article');
    }

    /**
     * 获取分类列表
     * @return mixed
     */
    public static function getCategoryDataModel()
    {
        $category = self::all();
        $data = tree($category);
        return $data;
    }

    /**
     * 取得树结构的分类数组
     * @return array
     */
    public static function getCategoryTree()
    {
        $data = self::getCategoryDataModel();
        foreach ($data as $k => $v) {
            self::$categoryData[$v->id] = $v->html . $v->name;
        }

        return self::$categoryData;
    }

    /**
     * 根据别名取分类信息
     * @param $id
     * @return mixed
     */
    public static function getCategoryModel($id)
    {
        if (is_numeric($id)) {
            return self::findOrFail($id);
        } else {
            return self::where('slug', '=', $id)->first();
        }

    }
}
