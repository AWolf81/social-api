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

		// auth passed --> attempt is also returning a token but we'd like to have custom claims in the token
		// so we're creating a token
		// --> added to user model
		// $user = $this->auth->user();
		// $customClaims = ['user' => $user, 'baz' => 'bob'];

		// $payload = JWTFactory::make($customClaims);

		// $token = JWTAuth::encode($payload);

		// all good so return the token
		return response()->json( compact( 'token' ) );
	}
}