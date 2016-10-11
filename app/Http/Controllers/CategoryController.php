<?php 

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Pagination\BootstrapThreePresenter;

class CategoryController extends Controller
{
    /**
     * display the articles of the given category
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $category = Category::getCategoryModel($id);
        if (empty($category)) {
            return redirect(url(route('article.index')));
        }

        $articles = $category->articles()->latest()->paginate(8);

        $jumbotron = [];
        $jumbotron['title'] = '分类：'.$category->name;
        $jumbotron['desc'] = $category->seo_desc;

        return view('pages.list', compact('category', 'articles', 'page', 'jumbotron'));
    }
}
