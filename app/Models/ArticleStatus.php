<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleStatus extends Model {

	//
    protected $table = 'article_status';

    public $timestamps = false;

    protected $fillable = [
        'article_id',
        'views',
    ];

    public function article(){
        return $this->hasOne('App\Models\Article','id','article_id');
    }

    public static function initArticleStatus($articleId){
        if(self::insert(array('article_id'=>$articleId))){
            return true;
        }else{
            return false;
        }
    }

    public static function deleteArticleStatus($article_id){
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
