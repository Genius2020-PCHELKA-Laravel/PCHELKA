<?php

use Illuminate\Database\Seeder;

class UserLocationsSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_locations')->delete();
        DB::table('user_locations')->insert([
            [
                'id' => '1',
                'address' => 'homs',
                'lat' => '33.33',
                'lon' =>'33.33',
                'details' => 'testesteste',
                'area' => 'asfhs',
                'street' => 'asmhdd',
                'buildingNumber' => 0,
                'apartment' => 0,
                'userId' => 1,
            ],
            [
                'id' => '2',
                'address' => 'homs',
                'lat' => '33.33',
                'lon' =>'33.33',
                'details' => 'testesteste',
                'area' => 'asfhs',
                'street' => 'asmhdd',
                'buildingNumber' => 0,
                'apartment' => 0,
                'userId' => 1,
            ],
        ]);
    }
}
