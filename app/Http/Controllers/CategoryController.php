<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Article;
use App\Category;
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

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function list()
    {
        $category = Category::getCategoryDataModel();
        return view('category.list', compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $categoryTree = Category::getCategoryTree();
        return view('category.create', compact('categoryTree'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CategoryRequest $request)
    {
        try {

            if (Category::create($request->all())) {
                Notification::success('添加成功');
                return redirect()->route('category.list');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(array('error' => $e->getMessage()))->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update(Category $category, CategoryRequest $request)
    {
        try {
            $updateData = $request->all();
            if ($category->update($updateData)) {
                Notification::success('更新成功');
                return redirect()->route('category.list');
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
        //
        $son = Category::where('parent_id', '=', $id)->get()->toArray();
        if (!empty($son)) {
            Notification::error('请先删除下级分类');
            return redirect()->route('category.list');
        }
        if (Category::destroy($id)) {
            Notification::success('删除成功');
            return redirect()->route('category.list');
        }
    }
}
