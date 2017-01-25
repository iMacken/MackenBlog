<?php

namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

class ArticleRepository extends Repository
{
    protected $visitor;

    public function __construct(VisitorRepository $visitor)
    {
        $this->visitor = $visitor;
    }

	public function model() {
		return 'App\Article';
	}
	
    /**
     * Sync the tags for the article.
     *
     * @param  array $tags
     * @return Paginate
     */
    public function syncTag(array $tags)
    {
        $this->model->tags()->sync($tags);
    }

    /**
     * Search the articles by the keyword.
     *
     * @param  string $key
     * @return collection
     */
    public function search($key)
    {
        $key = trim($key);

        return $this->model
                    ->where('title', 'like', "%{$key}%")
                    ->orderBy('published_at', 'desc')
                    ->get();

    }

    /**
     * get a list of tag ids associated with the current article
     * @return [array]
     */
    public function getTagListAttribute()
    {
        return $this->tags->pluck('id')->all();
    }

    /**
     * get archive list of articles
     * @param  integer $limit [description]
     * @return [type]         [description]
     */
    public function getArchiveList($limit = 12)
    {
        return $this->model->select(DB::raw("DATE_FORMAT(`created_at`, '%Y %m') as `archive`, count(*) as `count`"))
                ->where('category_id', '<>', 0)
                ->groupBy('archive')
                ->orderBy('archive', 'desc')
                ->limit($limit)
                ->get();
    }

    /**
     * get latest articles
     * @param int $pageNum
     * @return mixed
     */
    public function getLatestArticleList($pageNum = 10)
    {
        return $this->model->select(['id','title','slug','content','created_at','category_id'])
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
    public function getArticleListByCategoryId($categoryId, $limit = 10)
    {
        return $this->model->select(['id','title','slug','content','created_at','category_id'])
                ->where('category_id', $categoryId)
                ->orderBy('id', 'desc')
                ->paginate($limit);
    }

    /**
     * get hot articles
     * @param int $limit
     * @return mixed
     */
    public function getHotArticleList($limit = 3)
    {
        $select = [
            'articles.id',
            'articles.pic',
            'articles.title',
            'articles.slug',
            'articles.created_at',
            'article_status.views',
        ];
        return $this->model->select($select)
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
    public function getArticleListByKeyword($keyword)
    {
        return $this->model->select(['id','title','slug','content','created_at','category_id'])
                ->where('title', 'like', "%$keyword%")
                ->orWhere('content', 'like', "%$keyword%")
                ->where('category_id', '<>', 0)
                ->orderBy('id', 'desc')
                ->paginate(8);
    }



}
