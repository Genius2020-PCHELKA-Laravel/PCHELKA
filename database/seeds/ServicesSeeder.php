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
                'type' => 1,
                'materialPrice' => 100,
                'hourPrice' => 100,
                'unit'=> 'Hour'
            ],
            [
                'id' => 2,
                'name' => 'AC Cleaning',
                'imgPath' => 'imgPath',
                'details' => null,
                'orderNumber' => 2,
                'type' => 2,
                'materialPrice' => 100,
                'hourPrice' => 100,
                'unit'=> 'Hour'
            ],
            [
                'id' => 3,
                'name' => 'Curtain Cleaning',
                'imgPath' => 'imgPath',
                'details' => null,
                'orderNumber' => 3,
                'type' => 3,
                'materialPrice' => 100,
                'hourPrice' => 100,
                'unit'=> 'Hour'

            ],
            [
                'id' => 4,
                'name' => 'Carpet Cleaning',
                'imgPath' => 'imgPath',
                'details' => null,
                'orderNumber' => 4,
                'type' => 4,
                'materialPrice' => 100,
                'hourPrice' => 100,
                'unit'=> 'Hour'

            ],
            [
                'id' => 5,
                'name' => 'Mattress Cleaning',
                'imgPath' => 'imgPath',
                'details' => null,
                'orderNumber' => 5,
                'type' => 5,
                'materialPrice' => 100,
                'hourPrice' => 100,
                'unit'=> 'Hour'

            ],
            [
                'id' => 6,
                'name' => 'Sofa Cleaning',
                'imgPath' => 'imgPath',
                'details' => null,
                'orderNumber' => 6,
                'type' => 6,
                'materialPrice' => 100,
                'hourPrice' => 100,
                'unit'=> 'Hour'

            ],
            [
                'id' => 7,
                'name' => 'Deep Cleaning',
                'imgPath' => 'imgPath',
                'details' => null,
                'orderNumber' => 7,
                'type' => 7,
                'materialPrice' => 100,
                'hourPrice' => 100,
                'unit'=> 'Hour'

            ],
            [
                'id' => 8,
                'name' => 'Car Wash',
                'imgPath' => 'imgPath',
                'details' => null,
                'orderNumber' => 8,
                'type' => 8,
                'materialPrice' => 100,
                'hourPrice' => 100,
                'unit'=> 'Hour'

            ],
            [
                'id' => 9,
                'name' => 'Laundry',
                'imgPath' => 'imgPath',
                'details' => null,
                'orderNumber' => 9,
                'type' => 9,
                'materialPrice' => 100,
                'hourPrice' => 100,
                'unit'=> 'Hour'

            ],
            [
                'id' => 10,
                'name' => 'Full Time Maid',
                'imgPath' => 'imgPath',
                'details' => null,
                'orderNumber' => 10,
                'type' => 10,
                'materialPrice' => 100,
                'hourPrice' => 100,
                'unit'=> 'Hour'

            ],
            [
                'id' => 11,
                'name' => 'Disinfection Service',
                'imgPath' => 'imgPath',
                'details' => null,
                'orderNumber' => 11,
                'type' => 11,
                'materialPrice' => 100,
                'hourPrice' => 100,
                'unit'=> 'Hour'

            ],
            [
                'id' => 12,
                'name' => 'Babysitter Service',
                'imgPath' => 'imgPath',
                'details' => null,
                'orderNumber' => 12,
                'type' => 12,
                'materialPrice' => 100,
                'hourPrice' => 100,
                'unit'=> 'Hour'

            ],
        ]);
        //   factory(App\Models\Service::class,100)->create();
    }
}
