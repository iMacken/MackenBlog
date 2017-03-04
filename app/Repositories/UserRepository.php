<?php

namespace App\Repositories;

use Auth;

class UserRepository extends Repository
{
	static $tag = 'user';

	public function tag()
	{
		return UserRepository::$tag;
	}

	public function model()
	{
		return app(User::class);
	}

	/**
	 * Change the user password.
	 *
	 * @param  App\User $user
	 * @param  string $password
	 * @return boolean
	 */
	public function changePassword($user, $password)
	{
		return $user->update(['password' => bcrypt($password)]);
	}

	/**
	 * Save the user avatar path.
	 *
	 * @param  int $id
	 * @param  string $photo
	 * @return boolean
	 */
	public function saveAvatar($id, $photo)
	{
		$user = $this->getById($id);

		$user->avatar = $photo;

		return $user->save();
	}

}
