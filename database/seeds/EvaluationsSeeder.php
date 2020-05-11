<?php

use Illuminate\Database\Seeder;

class EvaluationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('evaluations')->delete();
        DB::table('evaluations')->insert([
            [
                'id' => 1,
                'starCount' => 4,
                'userId' => 1,
                'serviceProviderId' =>1,
                'bookingId' => 1,
            ],
            [
                'id' => 2,
                'starCount' => 4,
                'userId' => 1,
                'serviceProviderId' =>1,
                'bookingId' => 2,
            ],
            [
                'id' => 3,
                'starCount' => 4,
                'userId' => 3,
                'serviceProviderId' =>1,
                'bookingId' => 3,
            ],
        ]);
    }
}
