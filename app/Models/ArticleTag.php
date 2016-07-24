<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleTag extends Model {

    protected $table = 'article_tag';

    public $timestamps = false;

    protected $fillable = [
        'article_id',
        'tag_id',
    ];

    public function articles(){
        return $this->belongsToMany('App\Models\Article');
    }

    public static function initArticleTag($articleId){
        if(self::insert(array('article_id'=>$articleId))){
            return true;
        }else{
            return false;
        }
    }

    public static function deleteArticleTag($article_id){
        return self::where('article_id','=',$article_id)->first()->delete();
    }



    /**
     * 更新游览量
     * @param $articleId
     * @return mixed
     */
    public static function updateViewNumber($articleId){
        return self::where('article_id',$articleId)->increment('views');
    }

}
