<?php

namespace App\Policies;

use App\User;
use App\Article;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
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

    public function update(User $user, Article $article)
    {
	    return $user->id === $article->user_id;
    }

    public function delete(User $user, Article $article)
    {
	    return $user->id === $article->user_id;
    }
}
