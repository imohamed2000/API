<?php

use App\Events\SchoolCreated;
use App\File;
use Illuminate\Database\Seeder;

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
                $event_data = event( new SchoolCreated( $school ) );
                $school->roles = $event_data[0];
            }
        }
}
