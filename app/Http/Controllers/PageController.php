<?php

namespace App\Http\Controllers;

use App\Facades\Toastr;
use App\Repositories\PageRepository;
use App\Http\Requests\PageRequest;

class PageController extends Controller
{
    protected $pageRepository;

    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function show($slug)
    {
        $page = $this->pageRepository->get($slug);

        return view('page.show', compact('page'));
    }

    public function index()
    {
        $pages = $this->pageRepository->getAll();

        return view('page.index', compact('pages'));
    }

    public function create()
    {
        return view('page.create');
    }

    public function store(PageRequest $request)
    {
        $page = $this->pageRepository->create($request->all());

        if ($page) {
            Toastr::success('单页创建成功');
            return redirect()->route('page.index');

        }
        Toastr::error('单页创建失败');

        return redirect()->back()->withInput();
    }

    public function edit($id)
    {
        $page = $this->pageRepository->getById($id);

        return view('page.edit', compact('page'));
    }

    public function update(PageRequest $request, $id)
    {
        $result = $this->pageRepository->update($request->all(), $id);

        if ($result) {
            Toastr::success('单页修改成功');
            return redirect()->route('page.index');

        }
        Toastr::error('单页修改失败');

        return redirect()->back()->withInput();
    }

    public function destroy($id)
    {
        $result = $this->pageRepository->delete($id);

        if ($result) {
            return response()->json(['status' => 200, 'msg' => '单页删除成功']);
        }

        return response()->json(['status' => 500, 'msg' => '单页删除失败']);
    }
}
