<?php

use Illuminate\Database\Seeder;

class BookingAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('booking_answers')->delete();
        for ($i = 1; $i < 11; $i = $i + 2) {
            DB::table('booking_answers')->insert([
                [
                    'answerValue' => null,
                    'answerId' => '2',
                    'questionId' => '1',
                    'bookingId' => $i,
                ],
                [
                    'answerValue' => null,
                    'answerId' => '4',
                    'questionId' => '2',
                    'bookingId' => $i,
                ],
                [
                    'answerValue' => null,
                    'answerId' => '12',
                    'questionId' => '3',
                    'bookingId' => $i,
                ],
                [
                    'answerValue' => null,
                    'answerId' => '15',
                    'questionId' => '4',
                    'bookingId' => $i,
                ],
                [
                    'answerValue' => 'yes,please',
                    'answerId' => null,
                    'questionId' => '5',
                    'bookingId' => $i,
                ],
                ]);
        }
    }
}
