<?php

namespace App\Http\Controllers;

use App\User;
use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
// use App\Transformers\UserTransformer; // not used
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
	use Helpers;

	/**
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function index() {
		return User::all();
	}

	/**
	 * @param Request $request
	 *
	 * @return \Dingo\Api\Http\Response
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function register( Request $request )
	{
		// Validate request and throw ValidationException if data is incorrect
		$this->validate( $request, [
			'username' => 'required|unique:users',
			'name'     => 'required',
			'email'    => 'required|email|unique:users',
			'password' => 'required'
		] );
<<<<<<< HEAD
		$user = User::create( $request->all() );
		if ( $user ) {
			// return $this->response->item($user, new UserTransformer);
			// return $this->response->json($user);
			$token = JWTAuth::fromUser($user);
			// dd($token);
			return $this->response->created()->withHeader('Authorization', $token);
=======

		if ( User::create( $request->all() ) ) {
			return $this->response->created();
>>>>>>> 52377537c7bb312bd24d9fbba52f3bc6d87609b2
		}
	}

	/**
	 * @param $username
	 *
	 * @return mixed
	 */
	public function show( $username )
	{
		return User::username( $username )->first();
	}

	/**
	 * @param $username
	 *
	 * @return mixed
	 */
	public function friends( $username )
	{
		return User::username( $username )->first()->friends;
	}
}