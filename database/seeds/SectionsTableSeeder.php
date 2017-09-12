<?php

use App\Section;
use Illuminate\Database\Seeder;

class SectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sections = ['Section #1', 'Section #2', 'Section #3'];
        foreach($sections as $section){
        	$section = Section::create([
        			'name' 		=> $section,
        			'grade_id'	=> 1,
        			'school_id'	=> 1
        		]);
        }
    }
}
