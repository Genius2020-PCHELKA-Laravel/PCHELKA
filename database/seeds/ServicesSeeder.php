<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades;

class ServicesSeeder extends Seeder
{

    public function run()
    {
        DB::table('services')->delete();
        DB::table('services')->insert([
            [
                'id' => 1,
                'name' => 'Home Cleaning',
                'imgPath' => 'imgPath',
                'details' => 'Your trusted maid service',
                'orderNumber' => 1,
            ],
            [
                'id' => 2,
                'name' => 'AC Cleaning',
                'imgPath' => 'imgPath',
                'details' =>null,
                'orderNumber' => 2,
            ],
            [
                'id' => 3,
                'name' => 'Curtain Cleaning',
                'imgPath' => 'imgPath',
                'details' =>null,
                'orderNumber' => 3,
            ],
            [
                'id' => 4,
                'name' => 'Carpet Cleaning',
                'imgPath' => 'imgPath',
                'details' =>null,
                'orderNumber' => 4,
            ],
            [
                'id' => 5,
                'name' => 'Mattress Cleaning',
                'imgPath' => 'imgPath',
                'details' =>null,
                'orderNumber' => 5,
            ],
            [
                'id' => 6,
                'name' => 'Sofa Cleaning',
                'imgPath' => 'imgPath',
                'details' =>null,
                'orderNumber' => 6,
            ],
            [
                'id' => 7,
                'name' => 'Deep Cleaning',
                'imgPath' => 'imgPath',
                'details' =>null,
                'orderNumber' => 7,
            ],
            [
                'id' => 8,
                'name' => 'Car Wash',
                'imgPath' => 'imgPath',
                'details' =>null,
                'orderNumber' => 8,
            ],
            [
                'id' => 9,
                'name' => 'Laundry',
                'imgPath' => 'imgPath',
                'details' =>null,
                'orderNumber' => 9,
            ],
            [
                'id' => 10,
                'name' => 'Full Time Maid',
                'imgPath' => 'imgPath',
                'details' => null,
                'orderNumber' => 10,
            ],
            [
                'id' => 11,
                'name' => 'Disinfection Service',
                'imgPath' => 'imgPath',
                'details' =>null ,
                'orderNumber' => 11,
            ],
            [
                'id' => 12,
                'name' => 'Babysitter Service',
                'imgPath' => 'imgPath',
                'details' => null,
                'orderNumber' => 12,
            ],
        ]);
        //   factory(App\Models\Service::class,100)->create();
    }
}
