<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create( 'assets', function ( Blueprint $table ) {
			$table->increments( 'id' );
			$table->string( 'filename' );
			$table->unsignedInteger( 'user_id' );
			$table->timestamps();
			$table->foreign( 'user_id' )->references( 'id' )->on( 'users' );
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::drop( 'assets' );
	}
}