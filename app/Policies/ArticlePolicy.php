<?php

namespace App\Policies;

use App\User;
use App\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

	public function before($user, $ability)
	{
		/** @var User $user */
		if ($user->isSuperAdmin()) {
			return true;
		}
	}

	public function create(User $user)
	{
		return $user->isAdmin();
	}

    public function update(User $user, Post $post)
    {
	    return $user->id === $post->user_id;
    }

    public function delete(User $user, Post $post)
    {
	    return $user->id === $post->user_id;
    }
}
