<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use App\Repositories\CommentRepository;
use App\Repositories\ImageRepository;
use App\Repositories\MapRepository;
use App\Repositories\PageRepository;
use App\Repositories\ArticleRepository;
use App\Repositories\TagRepository;
use App\Repositories\UserRepository;
use App\Repositories\VisitorRepository;
use App\Http\Requests;
use DB;
use Illuminate\Http\Request;

class AdminController extends Controller
{
	protected $articleRepository;
	protected $commentRepository;
	protected $userRepository;
	protected $tagRepository;
	protected $categoryRepository;
	protected $pageRepository;
	protected $imageRepository;
	protected $mapRepository;
	protected $visitorRepository;

	/**
	 * AdminController constructor.
	 * @param ArticleRepository $articleRepository
	 * @param CommentRepository $commentRepository
	 * @param UserRepository $userRepository
	 * @param CategoryRepository $categoryRepository
	 * @param TagRepository $tagRepository
	 * @param PageRepository $pageRepository
	 * @param ImageRepository $imageRepository
	 * @param MapRepository $mapRepository
	 * @param visitorRepository $visitorRepository
	 * @internal param MapRepository $mapRepository
	 */
	public function __construct(ArticleRepository $articleRepository,
	                            CommentRepository $commentRepository,
	                            UserRepository $userRepository,
	                            CategoryRepository $categoryRepository,
	                            TagRepository $tagRepository,
	                            PageRepository $pageRepository,
	                            ImageRepository $imageRepository,
	                            MapRepository $mapRepository,
	                            VisitorRepository $visitorRepository)
	{
		$this->articleRepository  = $articleRepository;
		$this->commentRepository  = $commentRepository;
		$this->userRepository     = $userRepository;
		$this->categoryRepository = $categoryRepository;
		$this->tagRepository      = $tagRepository;
		$this->pageRepository     = $pageRepository;
		$this->imageRepository    = $imageRepository;
		$this->mapRepository      = $mapRepository;
		$this->visitorRepository  = $visitorRepository;
	}

	public function index()
	{
		$info                   = [];
		$info['article_count']  = $this->articleRepository->count();
		$info['comment_count']  = $this->commentRepository->count();
		$info['user_count']     = $this->userRepository->count();
		$info['category_count'] = $this->categoryRepository->count();
		$info['tag_count']      = $this->tagRepository->count();
		$info['page_count']     = $this->pageRepository->count();
		$info['image_count']    = $this->imageRepository->count();
		$info['visitor_count']  = $this->visitorRepository->count();

		$response = view('admin.index', compact('info'));
		if (($failed_jobs_count = DB::table('failed_jobs')->count()) > 0) {
			$failed_jobs_link = route('admin.failed-jobs');
			$response->withErrors(['failed_jobs' => "You have $failed_jobs_count failed jobs.<a href='$failed_jobs_link'>View</a>"]);
		}
		return $response;
	}

	public function settings()
	{
		return view('admin.settings');
	}

	public function saveSettings(Request $request)
	{
		$this->mapRepository->save($request->except('_token'));
		return back()->with('success', '保存成功');
	}

	public function failedJobs()
	{
		$failed_jobs = DB::table('failed_jobs')->get();
		return view('admin.failed_jobs', compact('failed_jobs'));
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
