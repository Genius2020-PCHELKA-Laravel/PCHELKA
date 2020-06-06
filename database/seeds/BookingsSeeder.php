<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

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
        for ($i = 1; $i < 40; $i++) {
            DB::table('bookings')->insert([
                [
                    'id' => $i,
                    'duoDate' => date('Y-m-d'),
                    'duoTime' => '08:00:00',
                    'refCode' => Str::random(6),
                    'subTotal' => 150,
                    'discount' => 0.0,
                    'totalAmount' => 150,
                    'paidStatus' => 1,
                    'serviceType' => mt_rand(1,12),
                    'paymentWays' => 1,
                    'status' => mt_rand(1, 2),
                    'userId' => mt_rand(1, 3),
                    'locationId' => mt_rand(1, 2),
                    'serviceId' => 1,
                    'providerId' => 1,
                ]
            ]);
        }
    }
}
