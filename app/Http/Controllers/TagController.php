<?php

namespace App\Http\Controllers;

use App\Facades\Toastr;
use App\Repositories\TagRepository;
use App\Http\Requests\TagRequest;

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
        $posts = $this->tagRepository->pagedPostsByTag($tag);

        return view('post.index', compact('posts'));
    }

    public function index()
    {
        $tags = $this->tagRepository->getAll();

        return view('tag.index', compact('tags'));
    }

    public function create()
    {
        return view('tag.create');
    }

    public function store(TagRequest $request)
    {
	    $result = $this->tagRepository->create($request->all());
        if ($result) {
            Toastr::success('标签创建成功');
            return redirect()->route('tag.index');
        }

	    Toastr::error('创建标签失败');

	    return redirect()->back()->withInput();
    }

    public function edit($id)
    {
	    $tag = $this->tagRepository->getById($id);

        return view('tag.edit', compact('tag'));
    }

    public function update(TagRequest $request, $id)
    {
        $result = $this->tagRepository->update($request->all(), $id);

	    if ($result) {
			Toastr::success('标签修改成功');
		    return redirect()->route('tag.index');
	    }
		Toastr::error('标签修改失败');

	    return redirect()->route('tag.index')->withInput();
    }

    public function destroy($id)
    {
	    $result = $this->tagRepository->delete($id);

	    if ($result) {
		    return response()->json(['status' => 200, 'msg' => '标签删除成功']);
	    }

	    return response()->json(['status' => 500, 'msg' => '标签删除失败']);
    }
}
