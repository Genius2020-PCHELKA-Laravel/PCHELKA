<?php

use Illuminate\Database\Seeder;

class SchedulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('schedules')->delete();
        DB::table('schedules')->insert([
            [
                'availableDate' => '2020-05-06',
                'id' => 1,
                'timeStart' => "05:00:00",
                'timeEnd' => '19:00:00',
                'serviceProviderId' => 1,
            ],
            [
                'availableDate' => '2020-05-07',
                'id' => 2,
                'timeStart' => "03:00:00",
                'timeEnd' => '14:00:00',
                'serviceProviderId' => 1,
            ],
            [
                'availableDate' => '2020-05-06',
                'id' => 3,
                'timeStart' => "05:00:00",
                'timeEnd' => '19:00:00',
                'serviceProviderId' => 2,
            ],
            [
                'availableDate' => '2020-05-07',
                'id' => 4,
                'timeStart' => "03:00:00",
                'timeEnd' => '14:00:00',
                'serviceProviderId' => 2,
            ],
        ]);
    }
}
