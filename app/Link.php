<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = [
        'sort',
        'name',
        'url',
        'image'
    ];

    /**
     * 获取链接列表
     * @param int $limit
     * @return mixed
     */
    public static function getLinkList($limit = 5)
    {
        return self::orderBy('sort', 'asc')->limit($limit)->get();
    }
}
