<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
	protected $hidden = [ 'user_id' ];
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'message'
	];

	public function user()
	{
		return $this->belongsTo( 'App\User' );
	}
}
