<?php

use Illuminate\Database\Seeder;

class BookingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bookings')->delete();
        DB::table('bookings')->insert([
            [
                'id' => 1,
                'duoDate' => now(),
                'price' => 150,
                'discount' => 0.0,
                'totalAmount' =>150,
                'status' => 1,
                'userId' => 1,
                'serviceId' => 1,
            ],
            [
                'id' => 2,
                'duoDate' => now(),
                'price' => 200,
                'discount' => 0.0,
                'totalAmount' =>200,
                'status' => 2,
                'userId' => 2,
                'serviceId' => 2,
            ],[
                'id' => 3,
                'duoDate' => now(),
                'price' => 222,
                'discount' => 0.0,
                'totalAmount' =>222,
                'status' => 2,
                'userId' => 3,
                'serviceId' => 1,
            ],
        ]);
    }
}
