<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Repositories\CommentRepository;
use Gate;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
	protected $commentRepository;

	public function __construct(CommentRepository $commentRepository)
	{
		$this->commentRepository = $commentRepository;
	}

	public function edit(Comment $comment)
	{
		return view('comment.edit', compact('comment'));
	}

	public function store(CommentRequest $request)
	{
		if ($comment = $this->commentRepository->create($request)) {
			return response()->json(['status' => 200, 'msg' => '发表成功']);
		}

		return response()->json(['status' => 500, 'msg' => '发表失败,请重试']);
	}


	public function show(Request $request, $commentable_id)
	{
		$commentable_type = $request->get('commentable_type');
		$comments = $this->commentRepository->getByCommentable($commentable_type, $commentable_id);
		$redirect = $request->get('redirect');
		return view('comment.show', compact('comments', 'commentable', 'redirect'));
	}

	public function destroy($comment_id)
	{
		$this->authorize('delete', $this->commentRepository->getById($comment_id));

		if ($this->commentRepository->delete($comment_id)) {
			return response()->json(['status' => 200, 'msg' => '删除成功']);
		}
		return response()->json(['status' => 500, 'msg' => '删除失败']);
	}
}
