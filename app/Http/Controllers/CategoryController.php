<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Pagination\BootstrapThreePresenter;

class CategoryController extends Controller
{
	protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
		$this->categoryRepository = $categoryRepository;
    }

    /**
     * display the articles of the given category
     *
     * @param  string $slug
     * @return Response
     */
    public function show($slug)
    {
        $category = $this->categoryRepository->get($slug);

        $articles = $this->categoryRepository->pagedArticlesByCategory($category);

        $jumbotron = [];
        $jumbotron['title'] = '分类：'.$category->name;
        $jumbotron['description'] = $category->description;

        return view('article.index', compact('category', 'articles', 'jumbotron'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $category = Category::getCategoryDataModel();
        return view('category.index', compact('category'));
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
     * @param CategoryRequest $request
     * @return Response
     */
    public function store(CategoryRequest $request)
    {
        try {

            if (Category::create($request->all())) {
                Notification::success('添加成功');
                return redirect()->route('category.index');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(array('error' => $e->getMessage()))->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Category $category
     * @return Response
     */
    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Category $category
     * @return Response
     */
    public function update(Category $category, CategoryRequest $request)
    {
        try {
            $updateData = $request->all();
            if ($category->update($updateData)) {
                Notification::success('更新成功');
                return redirect()->route('category.index');
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
            return redirect()->route('category.index');
        }
        if (Category::destroy($id)) {
            Notification::success('删除成功');
            return redirect()->route('category.index');
        }
    }
}
