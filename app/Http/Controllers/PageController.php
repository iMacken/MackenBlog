<?php 

namespace App\Http\Controllers;

use App\Http\Requests;

class PageController extends Controller {

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $article = Article::getArticleModel($id);
        ArticleStatus::updateViewNumber($article->id);
        $isSinglePage = true;
        return view('pages.show', compact('article','isSinglePage'));
	}

}
