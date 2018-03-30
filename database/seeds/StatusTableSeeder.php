<?php
use App\User;
use App\Status;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
class StatusTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Status::Create([
            'user_id' => User::where('username', 'test1')->first()->id,
            'message' => 'First status message'
        ]);
        Status::Create([
            'user_id' => User::where('username', 'test1')->first()->id,
            'message' => 'Second status message'
        ]);
        Status::Create([
            'user_id' => User::where('username', 'test2')->first()->id,
            'message' => 'Third status message - from other user'
        ]);
    }
}