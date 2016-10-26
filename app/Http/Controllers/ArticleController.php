<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Controller;

use App\Models\ArticleStatus;
use App\Models\Article;

use Parsedown;

class ArticleController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $articles = Article::getLatestArticleList(8);

        $jumbotron = [];
        $jumbotron['title'] = '麦肯先生';
        $jumbotron['desc'] = 'Simplicity is the essence of happiness.';

        return view('pages.list', compact('articles', 'jumbotron'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $article = Article::getArticleModel($id);
        ArticleStatus::updateViewNumber($article->id);
        return view('pages.show', compact('article'));
    }

    /**
     * display the articles archived by month
     * @param  [type] $year  [description]
     * @param  [type] $month [description]
     * @return [type]        [description]
     */
    public function archive($year, $month)
    {
        $articles = Article::getArchivedArticleList($year, $month, 8);

        $jumbotron = [];
        $jumbotron['title'] = '归档：'.$year.'年 '.$month.'月';
        $jumbotron['desc'] = '陈列在时光里的记忆，拂去轻尘，依旧如新。';

        return view('pages.list', compact('articles', 'jumbotron'));
    }

}
