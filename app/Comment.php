<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed commentable_type
 * @property mixed commentable_id
 */
class Comment extends Model
{
    use SoftDeletes;

    protected $fillable = ['content'];
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    protected $commentableData = [];

    public function getCommentableData()
    {
        if (empty($this->commentableData)) {
            switch ($this->commentable_type) {
                case 'App\Article':
                    $article = app('App\Article')->where('id', $this->commentable_id)->select('title', 'slug')->firstOrFail();
                    $this->commentableData['type'] = '文章';
                    $this->commentableData['title'] = $article->title;
                    $this->commentableData['url'] = route('article.show', $article->slug);
                    break;
                case 'App\Page':
                    $page = app('App\Page')->where('id', $this->commentable_id)->select('name', 'display_name')->firstOrFail();
                    $this->commentableData['type'] = '页面';
                    $this->commentableData['title'] = $page->display_name;
                    $this->commentableData['url'] = route('page.show', $page->name);
                    break;
            }
        }

        return $this->commentableData;
    }
}
