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
        $admin = [
        		"first_name"	=> 'Oxford',
        		"last_name"		=> 'Digital',
        		"email"			=> "admin@site.com",
        		"password"		=> bcrypt("secret")
        ];

        $moderator = [
        		"title"			=> 'Mr,',
        		"first_name"	=> "Ahmed",
        		"last_name"		=> "Hamdy",
        		"email"			=> "mod@site.com",
        		"password"		=> bcrypt("secret")
        ];

        $student = [
        		"first_name"	=> "Omar",
        		"last_name"		=> "Mahmoud",
        		"email"			=> "student@site.com",
        		"password"		=> bcrypt("secret")
        ];

        $father = [
        		"title"			=> "Dr.",
        		"first_name"	=> 'Mahmoud',
        		"last_name"		=> "Amin",
        		"email"			=> "father@site.com",
        		"password"		=> bcrypt("secret")
        ];

        $teacher = [
            "title"         => "Mr.",
            "first_name"    => 'Muhamad',
            "last_name"     => "Shukry",
            "email"         => "teacher@site.com",
            "password"      => bcrypt("secret")
        ];

        $users = [$admin, $student, $father, $teacher, $moderator];
        foreach ($users as $user) {
        	$user = \App\User::create( $user );
            if($user->id != 1){
                $user->schools()->sync([1]);
                $role = \App\Role::find( $user->id - 1 );
                $user->roles()->save( $role , ['school_id'   => 1] );
            }
        }

        // Attaching admin support role
        $admin_role = \App\Support::create([
                'user_id'   => 1,
                'role'      => 'support_admin'
            ]);
    }
}
