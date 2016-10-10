<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Tag;
use Illuminate\Pagination\BootstrapThreePresenter;

class TagController extends Controller
{
    public function show($id)
    {
        $tag = Tag::getTagModel($id);
        $tagName = $tag->name;
        $articles = $tag->articles()->where('category_id', '<>', 0)->paginate(8);

        $jumbotron = [];
        $jumbotron['title'] = '标签：' . $tagName;
        $jumbotron['desc'] = '梦里花落知多少，贴上标签方便找~';

        return view('pages.list', compact('tagName', 'articles', 'page', 'jumbotron'));
    }
}
