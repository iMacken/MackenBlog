<?php namespace App\Http\Controllers;

use Illuminate\Pagination\BootstrapThreePresenter;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SearchController extends Controller
{

    public function show($keyword)
    {
        if (empty($keyword)) {
            return redirect()->route('article.index');
        }

        #search articles from elasticsearch index
        $articles = Article::searchIndex($keyword);

        #if failed, directly search with mysql
        if (!$articles) {
            $articles = Article::getArticleListByKeyword($keyword);
        }

        $jumbotron = [];
        $jumbotron['title'] = '关键词：' . $keyword;
        $jumbotron['desc'] = '';

        return view('pages.list', compact('keyword', 'articles', 'page', 'jumbotron'));
    }

}
