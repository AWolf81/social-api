<?php

namespace App\Http\Controllers;

use App\User;
use App\Status;
use App\Events\NewStatus;
use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;

class StatusController extends Controller
{
	use Helpers;

	/**
	 * Get all status
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function index() {
		return Status::all();
	}

	/**
	 * @param $username
	 *
	 * @return mixed
	 */
	public function statusUpdates( $username ) {
		// dd($username);
		// if(!$username) {
		// 	$user = $this->auth->user();
		// 	$username = $user->username;
		// }
		return User::username( $username )->first()->statusUpdates;
	}

	/**
	 * @param Request $request
	 *
	 * @return \Dingo\Api\Http\Response
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function createStatusUpdate( Request $request )
	{
		$user = $this->auth->user();

		// Validate request and throw ValidationException if incorrect
		$this->validate( $request, [
			'message' => 'required'
		] );

		$status = new Status();
		$status->message = $request->message;
		$user->statusUpdates()->save( $status );
		
		event(new NewStatus($status));
		return $this->response->created();
	}

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function editStatusUpdate( Request $request )
	{
		$user    = $this->auth->user();
		$comment = $user->statusUpdates->find( $request->id );
		$comment->update( [ 'message' => $request->message ] );

		// todo trigger event status update

		return $this->response->accepted();
	}

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function deleteStatusUpdate( Request $request )
	{
		$user    = $this->auth->user();
		$comment = $user->statusUpdates->find( $request->id );
		$comment->delete();

		// todo trigger event status delete

		return $this->response->accepted();
	}
}