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

        $begin = new DateTime("08:00");
        $end = new DateTime("16:00");
        $interval = DateInterval::createFromDateString('30 min');
        $times = new DatePeriod($begin, $interval, $end);
        $date = date("Y-m-d");

        for ($i = 0; $i < 20; $i++) {
            foreach ($times as $time) {
                DB::table('schedules')->insert(
                    [
                        'availableDate' => date('Y-m-d', strtotime($date . ' +1 day')),
                        'timeStart' => $time->format('H:i'),
                        'timeEnd' => $time->add($interval)->format('H:i'),
                        'serviceProviderId' => 1,
                    ]);
            }
            foreach ($times as $time) {
                DB::table('schedules')->insert(
                    [
                        'availableDate' => date('Y-m-d', strtotime($date . ' +1 day')),
                        'timeStart' => $time->format('H:i'),
                        'timeEnd' => $time->add($interval)->format('H:i'),
                        'serviceProviderId' => 2,
                    ]);
            }
            foreach ($times as $time) {
                DB::table('schedules')->insert(
                    [
                        'availableDate' => date('Y-m-d', strtotime($date . ' +1 day')),
                        'timeStart' => $time->format('H:i'),
                        'timeEnd' => $time->add($interval)->format('H:i'),
                        'serviceProviderId' => 3,
                    ]);
            }
            foreach ($times as $time) {
                DB::table('schedules')->insert(
                    [
                        'availableDate' => date('Y-m-d', strtotime($date . ' +1 day')),
                        'timeStart' => $time->format('H:i'),
                        'timeEnd' => $time->add($interval)->format('H:i'),
                        'serviceProviderId' => 4,
                    ]);
            }
            foreach ($times as $time) {
                DB::table('schedules')->insert(
                    [
                        'availableDate' => date('Y-m-d', strtotime($date . ' +1 day')),
                        'timeStart' => $time->format('H:i'),
                        'timeEnd' => $time->add($interval)->format('H:i'),
                        'serviceProviderId' => 5,
                    ]);
            }
            foreach ($times as $time) {
                DB::table('schedules')->insert(
                    [
                        'availableDate' => date('Y-m-d', strtotime($date . ' +1 day')),
                        'timeStart' => $time->format('H:i'),
                        'timeEnd' => $time->add($interval)->format('H:i'),
                        'serviceProviderId' => 6,
                    ]);
            }
            foreach ($times as $time) {
                DB::table('schedules')->insert(
                    [
                        'availableDate' => date('Y-m-d', strtotime($date . ' +1 day')),
                        'timeStart' => $time->format('H:i'),
                        'timeEnd' => $time->add($interval)->format('H:i'),
                        'serviceProviderId' => 7,
                    ]);
            }
            foreach ($times as $time) {
                DB::table('schedules')->insert(
                    [
                        'availableDate' => date('Y-m-d', strtotime($date . ' +1 day')),
                        'timeStart' => $time->format('H:i'),
                        'timeEnd' => $time->add($interval)->format('H:i'),
                        'serviceProviderId' => 8,
                    ]);
            }
            foreach ($times as $time) {
                DB::table('schedules')->insert(
                    [
                        'availableDate' => date('Y-m-d', strtotime($date . ' +1 day')),
                        'timeStart' => $time->format('H:i'),
                        'timeEnd' => $time->add($interval)->format('H:i'),
                        'serviceProviderId' => 9,
                    ]);
            }
            foreach ($times as $time) {
                DB::table('schedules')->insert(
                    [
                        'availableDate' => date('Y-m-d', strtotime($date . ' +1 day')),
                        'timeStart' => $time->format('H:i'),
                        'timeEnd' => $time->add($interval)->format('H:i'),
                        'serviceProviderId' => 10,
                    ]);
            }
            $date = date('Y-m-d', strtotime($date . ' +1 day'));
        }
    }
}
