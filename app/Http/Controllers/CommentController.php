<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Repositories\CommentRepository;
use App\Http\Requests;
use Gate;
use Illuminate\Http\Request;
use XblogConfig;

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

	public function update(Request $request, Comment $comment)
	{
		$this->checkPolicy('manager', $comment);

		if ($this->commentRepository->update($request->get('content'), $comment)) {
			$redirect = request('redirect');
			if ($redirect)
				return redirect($redirect)->with('success', '修改成功');
			return back()->with('success', '修改成功');
		}
		return back()->withErrors('修改失败');
	}

	public function store(Request $request)
	{
		if (!$request->get('content')) {
			return response()->json(
				['status' => 500, 'msg' => 'Comment content must not be empty !']
			);
		}
		if (!auth()->check()) {
			if (!($request->get('username') && $request->get('email'))) {
				return response()->json(
					['status' => 500, 'msg' => 'Username and email must not be empty !']
				);
			}
			$pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
			if (!preg_match($pattern, request('email'))) {
				return response()->json(
					['status' => 500, 'msg' => 'An Invalidate Email !']
				);
			}
		}

		if ($comment = $this->commentRepository->create($request))
			return response()->json(['status' => 200, 'msg' => 'success']);
		return response()->json(['status' => 500, 'msg' => 'failed']);
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
		if (request('force') == 'true') {
			$comment = Comment::withTrashed()->findOrFail($comment_id);
		} else {
			$comment = Comment::findOrFail($comment_id);
		}

		$this->checkPolicy('manager', $comment);

		if ($this->commentRepository->delete($comment, request('force') == 'true')) {
			return back()->with('success', '删除成功');
		}
		return back()->withErrors('删除失败');
	}
}
