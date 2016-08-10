<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth, Request, Cache;
use Carbon\Carbon;
use App\Models\Tag;
use Elasticquent\ElasticquentTrait;
use Elasticquent\ElasticquentResultCollection;

class Article extends Model
{
    use ElasticquentTrait;

    protected $mappingProperties = array(
       'title' => array(
            'type' => 'string',
            'analyzer' => 'ik_max_word'
        ),
       'content' => array(
            'type' => 'string',
            'analyzer' => 'ik_max_word'
        )
    );

    protected $fillable = [
        'category_id',
        'user_id',
        'title',
        'slug',
        'content',
        'pic'
    ];

    /**
     * get the status of the current article
     * @return [type] [description]
     */
    public function status()
    {
        return $this->hasOne('App\Models\ArticleStatus', 'article_id');
    }

    /**
     * get the user of the current article
     * @return [type] [description]
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    /**
     * get the category of the current article
     * @return [type] [description]
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }

    /**
     * get the tags associated with the given article
     * @return [type] [description]
     */
    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag')->withTimestamps();
    }

    /**
     * get a list of tag ids associated with the current article
     * @return [array]
     */
    public function getTagListAttribute()
    {
        return $this->tags->lists('id')->all();
    }

    /**
     * 范围查询
     * @param $query
     * @param $userId
     * @return mixed
     */
    public function scopeUserId($query, $userId)
    {
        return $query->where('user_id', '=', $userId);
    }

    /**
     * get article model
     * @param int $id
     * @return mixed
     */
    public static function getArticleModel($id)
    {
        if (is_numeric($id)) {
            return self::findOrFail($id);
        } else {
            return self::where('slug', '=', $id)->first();
        }
    }


    /**
     * get archived articles
     * @param int $year
     * @param int $month
     * @param int $limit
     * @return mixed
     */
    public static function getArchivedArticleList($year, $month, $limit = 8)
    {
        return self::select(['id','title','slug','content','created_at','category_id'])
                ->where(\DB::raw("DATE_FORMAT(`created_at`, '%Y %c')"), '=', "$year $month")
                ->where('category_id', '<>', 0)
                ->latest()
                ->paginate($limit);
    }

    /**
     * get archive list of articles
     * @param  integer $limit [description]
     * @return [type]         [description]
     */
    public static function getArchiveList($limit = 12)
    {
        return self::select(\DB::raw("DATE_FORMAT(`created_at`, '%Y %m') as `archive`, count(*) as `count`"))
                ->where('category_id', '<>', 0)
                ->orderBy('id', 'desc')
                ->groupBy('archive')
                ->limit($limit)
                ->get();
    }

    /**
     * get latest articles
     * @param int $pageNum
     * @return mixed
     */
    public static function getLatestArticleList($pageNum = 10)
    {
        return self::select(['id','title','slug','content','created_at','category_id'])
                ->where('category_id', '<>', 0)
                ->orderBy('id', 'desc')
                ->paginate($pageNum);
    }

    /**
     * get articles of the given category
     * @param $categoryId
     * @param int $limit
     * @return mixed
     */
    public static function getArticleListByCategoryId($categoryId, $limit = 10)
    {
        return self::select(['id','title','slug','content','created_at','category_id'])
                ->where('category_id', $categoryId)
                ->orderBy('id', 'desc')
                ->paginate($limit);
    }

    /**
     * get hot articles
     * @param int $limit
     * @param bool $page
     * @return mixed
     */
    public static function getHotArticleList($limit = 3)
    {
        $select = [
            'articles.id',
            'articles.pic',
            'articles.title',
            'articles.slug',
            'articles.created_at',
            'article_status.views',
        ];
        return self::select($select)
                ->leftJoin('article_status', 'articles.id', '=', 'article_status.article_id')
                ->where('category_id', '<>', 0)
                ->orderBy('article_status.views', 'desc')
                ->limit($limit)
                ->get();
    }

    /**
     * get articles associated with the given keyword
     * @param $keyword
     * @return mixed
     */
    public static function getArticleListByKeyword($keyword)
    {
        return self::select(['id','title','slug','content','created_at','category_id'])
                ->where('title', 'like', "%$keyword%")
                ->where('category_id', '<>', 0)
                ->orderBy('id', 'desc')
                ->paginate(8);
    }

    /**
     * get articles associated with the given keyword in elasticsearch index
     * @param $keyword
     * @return mixed
     */
    public static function searchIndex($keyword)
    {
        try {
            $query = ['filtered' => [
                'filter' => ['range' => ['category_id' => ['gt' => 0]]],
                'query'  => [
                    ['multi_match'=>[
                        'query' => $keyword, 
                        'fields'=>['title', 'content']]
                    ],
                ],
            ]];
            $fields = ['id','title','slug','content','created_at','category_id'];

            $perPage = 8;
            $page = \Request::input('page');
            !$page && $page = 1;
            $offset = ($page - 1) * $perPage;
            return self::searchByQuery($query, null, $fields, $perPage, $offset)->paginate($perPage);
        } catch (Exception $e) {
            return false;
        }
    }

}
