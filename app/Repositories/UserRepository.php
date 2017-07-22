<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends Repository
{
	static $tag = 'user';

	public function tag()
	{
		return UserRepository::$tag;
	}

	/**
	 * @return User
	 */
	public function model()
	{
		return app(User::class);
	}
	
	public function getById($id)
	{
		return $this->model()->find($id);
	}

	public function create(array $data)
	{
		return $this->model()->create($data);
	}

	public function update($id, array $data)
	{
		$user = $this->getById($id);

		return $user->update($data);
	}

	public function delete($id)
	{
		/** @var User $user */
		$user = self::getById($id);
		$result = $user->destroy($id);

		return $result;
	}

}
