<?php

namespace App\Http\Controllers;

use App\Category;
use App\Facades\Toastr;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Response;
use Illuminate\Pagination\BootstrapThreePresenter;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
	protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
		$this->categoryRepository = $categoryRepository;
    }

    /**
     * display the posts of the given category
     *
     * @param  string $slug
     * @return Response
     */
    public function show($slug)
    {
        $category = $this->categoryRepository->get($slug);

        $posts = $this->categoryRepository->pagedPostsByCategory($category);

        $jumbotron = [];
        $jumbotron['title'] = '分类：'.$category->name;
        $jumbotron['description'] = $category->description;

        return view('post.index', compact('category', 'posts', 'jumbotron'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $categories = $this->categoryRepository->getAll();

        return view('category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryRequest $request
     * @return Response
     */
    public function store(CategoryRequest $request)
    {
	    $post = $this->categoryRepository->create($request->all());

	    if ($post) {
		    Toastr::success('分类创建成功');
		    return redirect()->route('category.index');

	    }
	    Toastr::error('分类创建失败');

	    return redirect()->back()->withInput();
    }

    public function edit($id)
    {
	    $category = $this->categoryRepository->getById($id);

        return view('category.edit', compact('category'));
    }

    public function update(CategoryRequest $request, $id)
    {
	    $result = $this->categoryRepository->update($request->all(), $id);

	    if ($result) {
		    Toastr::success('分类修改成功');
		    return redirect()->route('category.index');

	    }
	    Toastr::error('分类修改失败');

	    return redirect()->back()->withInput();
    }

    public function destroy($id)
    {
	    $result = $this->categoryRepository->delete($id);

	    if ($result) {
		    return response()->json(['status' => 200, 'msg' => '分类删除成功']);
	    }

	    return response()->json(['status' => 500, 'msg' => '分类删除失败']);
    }
}
