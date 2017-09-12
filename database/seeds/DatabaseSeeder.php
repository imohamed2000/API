<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->call(FilesTableSeeder::class);
        $this->call(SchoolTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(GradesTableSeeder::class);
        $this->call(SectionsTableSeeder::class);
    }
}
