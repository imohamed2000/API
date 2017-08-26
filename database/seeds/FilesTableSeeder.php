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

        // Male avatar
        $male_avatar = new File();
        $male_avatar ->filename = 'users/avatar/male.png';
        $male_avatar ->original_name = 'male.png';
        $male_avatar ->type = 'image/png';
        $male_avatar ->size = '6625.28';
        $male_avatar ->extension = '.png';
        $male_avatar ->save();

        // Female avatar
        $male_avatar = new File();
        $male_avatar ->filename = 'users/avatar/female.png';
        $male_avatar ->original_name = 'male.png';
        $male_avatar ->type = 'image/png';
        $male_avatar ->size = '6625.28';
        $male_avatar ->extension = '.png';
        $male_avatar ->save();

        // School Logo
        $schoolLogo = new File();
        $schoolLogo->filename = 'schools/logo/school.png';
        $schoolLogo->original_name = 'school.png';
        $schoolLogo->type = 'image/png';
        $schoolLogo->size = '6625.28';
        $schoolLogo->extension = '.png';
        $schoolLogo->save();

    }
}
