<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UploadedFile extends Model
{
    public static $paginate = 10;
    public static $order = 'created_at';
    public static $sort = 'desc';

    protected $fillable = ['title', 'category_id', 'description', 'path', 'link', 'order'];

}
