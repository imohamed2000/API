<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //this is created only to test authentication
        // we may need further more data
        $user = factory( App\User::class )->create([
        		'email'	=> 'user@site.com'
        	]);
    }
}
