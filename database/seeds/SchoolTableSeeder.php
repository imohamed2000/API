<?php

use Illuminate\Database\Seeder;
use App\File;

class SchoolTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $first_school = [
                'name'  => 'Odigita School',
                'slug'  => str_slug('Odigita School'),
                'email' => 'first_school@site.com'
            ];

        $second_school =[
                'name'  => 'مدرسة النجاح',
                'slug'  => str_slug('مدرسة النجاح'),
                'email' => 'second_school@site.com'
            ];

        $schools = [ $first_school, $second_school ];

        foreach($schools as $school){
            $school = \App\School::create( $school );
            $default_roles = ['Student', 'Parent', 'Teacher', 'Moderator'];
            foreach ($default_roles as $role_name) {
                $role = \App\Role::create(['name'   => $role_name, 'slug' => str_slug($role_name)]);
                \DB::table('role_school')->insert([
                        'role_id'   => $role->id,
                        'school_id' => $school->id,
                    ]);
            }
        }
        
    }
}
