<?php

namespace App\Http\Controllers;

use App\Facades\Toastr;
use App\Repositories\CategoryRepository;
use App\Repositories\PostRepository;
use App\Repositories\TagRepository;
use App\Http\Requests\PostRequest;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{

    protected $postRepository;
    protected $categoryRepository;
    protected $tagRepository;

    public function __construct(PostRepository $postRepository,
                                CategoryRepository $categoryRepository,
                                TagRepository $tagRepository)
    {
        $this->postRepository  = $postRepository;
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository      = $tagRepository;

	    $this->middleware(['auth', 'admin'], ['except' => ['show', 'index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
	    $posts = $this->postRepository->paginate();

        $jumbotron = [];
        $jumbotron['title'] = config('blog.default_owner');
        $jumbotron['description'] = config('blog.default_motto');

        return view('post.index', compact('posts', 'jumbotron'));
    }


    /**
     * Display the specified resource.
     *
     * @param  string $slug
     * @return Response
     */
    public function show($slug)
    {
	    $post = $this->postRepository->get($slug);

        return view('post.show', compact('post'));
    }

    /**
     * display the posts archived by month
     * @param  [type] $year  [description]
     * @param  [type] $month [description]
     * @return Response
     */
    public function archive($year, $month)
    {
        $posts = $this->postRepository->archive(12);

        $jumbotron = [];
        $jumbotron['title'] = '归档：'.$year.'年 '.$month.'月';
        $jumbotron['desc'] = '陈列在时光里的记忆，拂去轻尘，依旧如新。';

        return view('pages.list', compact('posts', 'jumbotron'));
    }

    public function create()
    {
	    $this->authorize('create', Post::class);

	    return view('post.create', [
		    'categories' => $this->categoryRepository->getAll(),
		    'tags' => $this->tagRepository->getAll(),
	    ]);
    }

    public function store(PostRequest $request)
    {
	    $this->authorize('create', Post::class);

	    $post = $this->postRepository->create($request->all());

	    if ($post) {
		    Toastr::success('文章创建成功');
		    return redirect()->route('post.show', ['slug' => $post->slug]);

	    }
	    Toastr::error('文章创建失败');

	    return redirect()->back()->withInput();
    }

    public function edit($id)
    {
	    return view('post.edit', [
		    'post' => $this->postRepository->getById($id),
		    'categories' => $this->categoryRepository->getAll(),
		    'tags' => $this->tagRepository->getAll(),
	    ]);
    }

    public function update(PostRequest $request, $id)
    {
	    $this->authorize('update', $this->postRepository->getById($id));

	    $result = $this->postRepository->update($request->all(), $id);

	    if ($result) {
		    Toastr::success('文章更新成功');
		    return redirect()->route('post.show', ['slug' => $request->input('slug')]);
	    }
	    Toastr::error('文章更新失败');

	    return redirect()->back()->withInput();
    }

    public function destroy($id)
    {
	    $this->authorize('delete', $this->postRepository->getById($id));

	    $result = $this->postRepository->delete($id);

        if ($result) {
	        Toastr::success('文章删除成功');
	        return redirect()->route('post.index');
        }
	    Toastr::success('文章删除失败');

	    return redirect()->back();
    }

	public function search(Request $request)
	{
		$keyword = trim($request->input('keyword'));
		if (! $keyword) {
			return redirect()->route('post.index');
		}

		$posts = $this->postRepository->search($keyword);

		return view('post.search', compact('keyword', 'posts'));
	}
}
