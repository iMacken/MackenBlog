<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use App\Repositories\CommentRepository;
use App\Repositories\PageRepository;
use App\Repositories\PostRepository;
use App\Repositories\TagRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminController extends Controller
{
	protected $postRepository;
	protected $commentRepository;
	protected $userRepository;
	protected $tagRepository;
	protected $categoryRepository;
	protected $pageRepository;
	protected $imageRepository;
	protected $mapRepository;

	/**
	 * AdminController constructor.
	 * @param PostRepository $postRepository
	 * @param CommentRepository $commentRepository
	 * @param UserRepository $userRepository
	 * @param CategoryRepository $categoryRepository
	 * @param TagRepository $tagRepository
	 * @param PageRepository $pageRepository
	 * @internal param MapRepository $mapRepository
	 */
	public function __construct(PostRepository $postRepository,
	                            CommentRepository $commentRepository,
	                            UserRepository $userRepository,
	                            CategoryRepository $categoryRepository,
	                            TagRepository $tagRepository,
	                            PageRepository $pageRepository)
	{
		$this->postRepository  = $postRepository;
		$this->commentRepository  = $commentRepository;
		$this->userRepository     = $userRepository;
		$this->categoryRepository = $categoryRepository;
		$this->tagRepository      = $tagRepository;
		$this->pageRepository     = $pageRepository;
	}

	public function index()
	{
		$info                   = [];
		$info['post_count']  = $this->postRepository->count();
		$info['comment_count']  = $this->commentRepository->count();
		$info['user_count']     = $this->userRepository->count();
		$info['category_count'] = $this->categoryRepository->count();
		$info['tag_count']      = $this->tagRepository->count();
		$info['page_count']     = $this->pageRepository->count();
		$info['image_count']    = $this->imageRepository->count();

		$response = view('index', compact('info'));
		if (($failed_jobs_count = DB::table('failed_jobs')->count()) > 0) {
			$failed_jobs_link = route('failed-jobs');
			$response->withErrors(['failed_jobs' => "You have $failed_jobs_count failed jobs.<a href='$failed_jobs_link'>View</a>"]);
		}
		return $response;
	}

	public function settings()
	{
		return view('settings');
	}

	public function saveSettings(Request $request)
	{
		$this->mapRepository->save($request->except('_token'));
		return back()->with('success', '保存成功');
	}

	public function failedJobs()
	{
		$failed_jobs = DB::table('failed_jobs')->get();
		return view('failed_jobs', compact('failed_jobs'));
	}

	public function flushFailedJobs()
	{
		$result = DB::table('failed_jobs')->delete();
		if ($result) {
			return back()->with('success', "Flush $result failed jobs");
		}
		return back()->withErrors("Flush failed jobs failed");
	}

}
