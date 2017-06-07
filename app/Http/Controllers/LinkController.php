<?php

namespace App\Http\Controllers;

use App\Facades\Toastr;
use App\Link;
use App\Http\Requests\LinkRequest;
use App\Repositories\LinkRepository;

class LinkController extends Controller
{
    protected $linkRepository;

    public function __construct(LinkRepository $linkRepository)
    {
        $this->linkRepository = $linkRepository;
    }

    public function index()
    {
        return view('link.index', [
            'links' => $this->linkRepository->getAll()
        ]);
    }

    public function create()
    {
        return view('link.create');
    }

    public function store(LinkRequest $request)
    {
        $article = $this->linkRepository->create($request->all());

        if ($article) {
            Toastr::success('友链创建成功');
            return redirect()->route('link.index');

        }
        Toastr::error('友链创建失败');

        return redirect()->back()->withInput();
    }

    public function edit($id)
    {
        $link = $this->linkRepository->getById($id);

        return view('link.edit', compact('link'));
    }

    public function update(LinkRequest $request, $id)
    {
        $result = $this->linkRepository->update($request->all(), $id);

        if ($result) {
            Toastr::success('友链修改成功');
            return redirect()->route('link.index');

        }
        Toastr::error('友链修改失败');

        return redirect()->back()->withInput();
    }

    public function destroy($id)
    {
        $result = $this->linkRepository->delete($id);

        if ($result) {
            return response()->json(['status' => 200, 'msg' => '友链删除成功']);
        }

        return response()->json(['status' => 500, 'msg' => '友链删除失败']);
    }
}
