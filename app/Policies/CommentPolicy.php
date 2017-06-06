<?php

namespace App\Policies;

use App\User;
use App\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        /** @var User $user */
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    /**
     * Determine if the given comment can be deleted by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Comment  $comment
     * @return bool
     */
    public function delete(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id;
    }
}
