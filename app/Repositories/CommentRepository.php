<?php
/**
 * Created by PhpStorm.
 * User: lufficc
 * Date: 2016/8/19
 * Time: 17:41
 */
namespace App\Http\Repositories;

use App\Comment;
use Illuminate\Http\Request;
use Lufficc\MarkDownParser;
use Lufficc\Mention;

/**
 * Class CommentRepository
 * @package App\Http\Repository
 */
class CommentRepository extends Repository
{
    static $tag = 'comment';
    protected $markdownParser;
    protected $mention;

    /**
     * PostRepository constructor.
     * @param Mention $mention
     * @param MarkDownParser $markDownParser
     */
    public function __construct(Mention $mention, MarkDownParser $markDownParser)
    {
        $this->mention = $mention;
        $this->markdownParser = $markDownParser;
    }

    public function model()
    {
        return app(Comment::class);
    }

    private function getCacheKey($commentable_type, $commentable_id)
    {
        return $commentable_type . '.' . $commentable_id . 'comments';
    }

    public function getByCommentable($commentable_type, $commentable_id)
    {
        $comments = $this->remember($this->getCacheKey($commentable_type, $commentable_id), function () use ($commentable_type, $commentable_id) {
            $commentable = app($commentable_type)->where('id', $commentable_id)->select(['id'])->firstOrFail();
            return $commentable->comments()->with(['user'])->get();
        });
        return $comments;
    }

    public function getAll($page = 20)
    {
        $comments = $this->remember('comment.page.' . $page . '' . request()->get('page', 1), function () use ($page) {
            return Comment::withoutGlobalScopes()->orderBy('created_at', 'desc')->paginate($page);
        });
        return $comments;
    }

    public function create(Request $request)
    {
        $this->clearCache();

        $comment = new Comment();
        $commentable_id = $request->get('commentable_id');
        $commentable = app($request->get('commentable_type'))->where('id', $commentable_id)->firstOrFail();

        if (auth()->check()) {
            $user = auth()->user();
            $comment->user_id = $user->id;
            $comment->username = $user->name;
            $comment->email = $user->email;
        } else {
            $comment->username = $request->get('username');
            $comment->email = $request->get('email');
            $comment->site = $request->get('site');
        }

        $content = $request->get('content');

        $comment->content = $this->mention->parse($content);
        $comment->html_content = $this->markdownParser->parse($comment->content);
        $result = $commentable->comments()->save($comment);

        /**
         * mention user after comment saved
         */
        $this->mention->mentionUsers($comment, getMentionedUsers($content), $content);

        return $result;
    }

    public function update($content, $comment)
    {
        $comment->content = $this->mention->parse($content);
        $comment->html_content = $this->markdownParser->parse($comment->content);
        $result = $comment->save();
        if ($result)
            $this->clearCache();
        return $result;
    }

    public function delete(Comment $comment, $force = false)
    {
        $this->clearCache();
        if ($force)
            return $comment->forceDelete();
        return $comment->delete();
    }

    public function tag()
    {
        return CommentRepository::$tag;
    }

}