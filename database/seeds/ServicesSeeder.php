<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades;

class ServicesSeeder extends Seeder
{

    public function run()
    {
        DB::table('services')->delete();
        DB::table('services')->insert([
            ['id' => 1, 'name' => 'HomeCleaning', 'imgPath' => 'jkasgdjhsagd', 'details' => 'hello from laravel seed'],
            ['id' => 2, 'name' => 'WashCars', 'imgPath' => 'jkasgdjhsagd', 'details' => 'hello from laravel seed'],
        ]);
        //   factory(App\Models\Service::class,100)->create();
    }
}
