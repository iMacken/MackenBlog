<?php

namespace App\Http\Controllers;

use App\Repositories\TagRepository;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Tag;
use Illuminate\Pagination\BootstrapThreePresenter;

class TagController extends Controller
{
    protected $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function show($slug)
    {
        $tag = $this->tagRepository->get($slug);
        $articles = $this->tagRepository->pagedArticlesByTag($tag);

        $jumbotron = [];
        $jumbotron['title'] = '标签：' . $tag->name;
        $jumbotron['description'] = '梦里花落知多少，贴上标签方便找~';

        return view('article.index', compact('tagName', 'articles', 'jumbotron'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $tags = Tag::orderBy('id', 'desc')->paginate(10);
        return view('tag.list', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('tag.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TagRequest $request
     * @return Response
     */
    public function store(TagRequest $request)
    {
        try {

            if (Tag::create($request->all())) {
                Notification::success('添加成功');
                return redirect()->route('tag.index');
            }

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(array('error' => $e->getMessage()))->withInput();
        }

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  Tag $tag
     * @return Response
     */
    public function edit(Tag $tag)
    {
        return view('tag.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TagRequest $request
     * @param  int $id
     * @return Response
     */
    public function update(TagRequest $request, $id)
    {
        try {

            if (Tag::where('id', $id)->update(['name'=>$request->input('name')])) {

                Notification::success('更新成功');

                return redirect()->route('tag.index');
            }

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(array('error' => $e->getMessage()))->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        if (Tag::destroy($id)) {
            Notification::success('删除成功');
        } else {
            Notification::error('删除失败');
        }
        return redirect()->route('tag.index');
    }

    public function getTags(Request $request)
    {
        $search = $request->input('search');
        return Tag::where('name', 'like', '%' . $search . '%')->paginate(10);
    }
}
