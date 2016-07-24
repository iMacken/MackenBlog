<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $table;
    protected $fillable = [
        'sort',
        'name',
        'url'
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
