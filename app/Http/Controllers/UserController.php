<?php

namespace App\Http\Controllers;

use App\User;
use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;

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
		$this->buildFailedValidationResponse($request, [
			'unique'    => 'username/email must be unique'
		]);

		$validator = Validator::make($request->all(), [
			'username' => 'required|unique:users',
			'name'     => 'required',
			'email'    => 'required|email|unique:users',
			'password' => 'required'
		] );
		
		if ($validator->fails()) {
			return $validator->errors();
		}

		$user = User::create( $request->all() );
		if ( $user ) {
			$token = JWTAuth::fromUser($user);
			return $this->response->created()->withHeader('Authorization', $token);
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