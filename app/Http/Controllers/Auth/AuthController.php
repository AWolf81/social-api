<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Dingo\Api\Http\Request;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends Controller
{
	protected $auth;

	public function __construct( JWTAuth $auth )
	{
		$this->auth = $auth;
	}

	public function authenticate( Request $request )
	{
		// grab credentials from the request
		$credentials = $request->input( 'email' ) ? $request->only( 'email', 'password' ) : $request->only( 'username', 'password' );

		try {
			// attempt to verify the credentials and create a token for the user
			if ( ! $token = $this->auth->attempt( $credentials ) ) {
				return response()->json( [ 'error' => 'invalid_credentials' ], 401 );
			}
		} catch ( \Exception $e ) {
			// something went wrong whilst attempting to encode the token
			return response()->json( [ 'error' => 'could_not_create_token' ], 500 );
		}

		$user = $this->auth->user();
		// all good so return the token & user
		return response()->json( compact( 'token', 'user' ) );
	}
}