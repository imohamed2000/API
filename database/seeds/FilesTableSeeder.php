<?php

use App\Beak\Upload;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\File;

class FilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $male = new File();
        $male->filename = str_random(122).'.png';
        $male->original_name = 'male.png';
        $male->type = 'image/png';
        $male->size = '30105.6';
        $male->extension = '.png';
        $male->save();

        DB::table('users')->insert([
            'first_name' => str_random(10),
            'last_name' => str_random(10),
            'gender' => 'male',
            'email' => str_random(10).'@gmail.com',
            'password' => bcrypt('secret'),
            'avatar'  => $male->id
        ]);

        $female = new File();
        $female->filename = str_random(122).'.png';
        $female->original_name = 'female.png';
        $female->type = 'image/png';
        $female->size = '30617.6';
        $female->extension = '.png';
        $female->save();

        DB::table('users')->insert([
            'first_name' => str_random(10),
            'last_name' => str_random(10),
            'gender' => 'female',
            'email' => str_random(10).'@gmail.com',
            'password' => bcrypt('secret'),
            'avatar'  => $female->id
        ]);


    }
}
