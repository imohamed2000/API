<?php

use Illuminate\Database\Seeder;

class GradesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $grade_one = [
        	'school_id'	=> 1,
        	'name'		=> 'Grade One',
            'order'     => 0
        ];

        $grade_two = [
        	'school_id'	=> 1,
        	'name'		=> 'Grade Two',
            'order'     => 1
        ];
        $grades = [$grade_one, $grade_two];
        foreach($grades as $attr){
        	$grade = \App\Grade::create( $attr );
        }
    }
}
