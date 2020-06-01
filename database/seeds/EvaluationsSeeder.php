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
        for ($i = 1; $i < 200; $i++) {
            DB::table('evaluations')->insert([
                [
                    'id' => $i,
                    'starCount' => mt_rand(2,5),
                    'userId' => mt_rand(1,2),
                    'serviceProviderId' => mt_rand(1,4),
                    'bookingId' => mt_rand(1,12),
                ]
            ]);
        }
    }
}
