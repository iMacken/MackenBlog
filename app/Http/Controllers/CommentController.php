<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Repositories\CommentRepository;
use Gate;
use Illuminate\Http\Request;
use XblogConfig;
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

	public function update(CommentRequest $request, Comment $comment)
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
