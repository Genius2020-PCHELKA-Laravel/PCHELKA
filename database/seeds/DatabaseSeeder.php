<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        DB::table('users')->insert([
            'id'     => '1',
            'fullname'     => 'maher',
            'email'    => 'maher_se84@hotmail.com',
            'password' => bcrypt('maher'),
            'mobile'=>'971554090055',
            'isVerified'=>0,
            'dateOfBirth'=> now()
        ]); 
        $this->call(ServicesSeeder::class);
    }
}
