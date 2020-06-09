<?php

use Illuminate\Database\Seeder;

class ProvidersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('providers')->delete();
        DB::table('providers')->insert([
            [
                'id' => 1,
                'name' => 'Belal',
                'email' => "B@b.c",
                'mobileNumber' => '0994665567',
                'imageUrl' => 'https://s3.amazonaws.com/uifaces/faces/twitter/ladylexy/128.jpg',
                'companyId' => null
            ],
            [
                'id' => 2,
                'name' => 'mohamad',
                'email' => "m@m.c",
                'mobileNumber' => '0994665567',
                'imageUrl' => 'https://s3.amazonaws.com/uifaces/faces/twitter/ladylexy/128.jpg',
                'companyId' => null
            ], [
                'id' => 3,
                'name' => 'samer',
                'email' => "m@m.c",
                'mobileNumber' => '0994665567',
                'imageUrl' => 'https://s3.amazonaws.com/uifaces/faces/twitter/adhamdannaway/128.jpg',
                'companyId' => null
            ], [
                'id' => 4,
                'name' => 'nour',
                'email' => "m@m.c",
                'mobileNumber' => '0994665567',
                'imageUrl' => 'https://s3.amazonaws.com/uifaces/faces/twitter/adhamdannaway/128.jpg',
                'companyId' => null
            ],
            [
                'id' => 5,
                'name' => 'diana',
                'email' => "m@m.c",
                'mobileNumber' => '0994665567',
                'imageUrl' => 'https://s3.amazonaws.com/uifaces/faces/twitter/ladylexy/128.jpg',
                'companyId' => null
            ],
            [
                'id' => 6,
                'name' => 'basssel',
                'email' => "B@b.c",
                'mobileNumber' => '0994665567',
                'imageUrl' => 'https://s3.amazonaws.com/uifaces/faces/twitter/ladylexy/128.jpg',
                'companyId' => null
            ],
            [
                'id' => 7,
                'name' => 'soha',
                'email' => "B@b.c",
                'mobileNumber' => '0994665567',
                'imageUrl' => 'https://s3.amazonaws.com/uifaces/faces/twitter/ladylexy/128.jpg',
                'companyId' => null
            ],
            [
                'id' => 8,
                'name' => 'zina',
                'email' => "B@b.c",
                'mobileNumber' => '0994665567',
                'imageUrl' => 'https://s3.amazonaws.com/uifaces/faces/twitter/ladylexy/128.jpg',
                'companyId' => null
            ],
            [
                'id' => 9,
                'name' => 'znzn',
                'email' => "B@b.c",
                'mobileNumber' => '0994665567',
                'imageUrl' => 'https://s3.amazonaws.com/uifaces/faces/twitter/ladylexy/128.jpg',
                'companyId' => null
            ],
            [
                'id' => 10,
                'name' => 'fatima',
                'email' => "B@b.c",
                'mobileNumber' => '0994665567',
                'imageUrl' => 'https://s3.amazonaws.com/uifaces/faces/twitter/ladylexy/128.jpg',
                'companyId' => null
            ],
            [
                'id' => 11,
                'name' => 'morad',
                'email' => "B@b.c",
                'mobileNumber' => '0994665567',
                'imageUrl' => 'https://s3.amazonaws.com/uifaces/faces/twitter/ladylexy/128.jpg',
                'companyId' => null
            ],
            [
                'id' => 12,
                'name' => 'mazen',
                'email' => "B@b.c",
                'mobileNumber' => '0994665567',
                'imageUrl' => 'https://s3.amazonaws.com/uifaces/faces/twitter/ladylexy/128.jpg',
                'companyId' => null
            ],
        ]);
    }
}
