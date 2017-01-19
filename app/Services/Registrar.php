<?php namespace App\Services;

use App\User;
use Validator;

class Registrar {

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		return Validator::make($data, [
			'name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|min:6',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  object  $Request
	 * @return User
	 */
	public function create(array $data)
	{
		$data['password'] = bcrypt($data['password']);
		return User::create($data);
	}

}
