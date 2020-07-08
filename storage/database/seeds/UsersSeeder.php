<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        DB::table('users')->insert([
            [
                'id' => '1',
                'fullname' => 'maher',
                'email' => 'maher_se84@hotmail.com',
                'password' => bcrypt('maher'),
                'mobile' => '971554090055',
                'isVerified' => 0,
            ],
            [
                'id' => '2',
                'fullname' => 'masher',
                'email' => 'maher_sse84@hotmail.com',
                'password' => bcrypt('mahser'),
                'mobile' => '971554092055',
                'isVerified' => 0,
            ],
            [
                'id' => '3',
                'fullname' => 'belal',
                'email' => 'belal@hotmail.com',
                'password' => bcrypt('belal'),
                'mobile' => '963994665567',
                'isVerified' => 0,
            ],
        ]);
    }
}
