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
        $schoolLogo = new File();
        $schoolLogo->filename = str_random(122).'.png';
        $schoolLogo->original_name = 'school.png';
        $schoolLogo->type = 'image/png';
        $schoolLogo->size = '6625.28';
        $schoolLogo->extension = '.png';

        $schoolLogo->save();

        DB::table('schools')->insert([
            'name' => str_random(10),
            'slug' => 'schoolA',
        ]);

        DB::table('schools')->insert([
            'name' => str_random(10),
            'slug' => 'schoolB',
        ]);
    }
}
