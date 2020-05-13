<?php

use Illuminate\Database\Seeder;

class ServicesQuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('services_questions')->delete();
        DB::table('services_questions')->insert([
            [
                'id' => 1,
                'serviceId' => 1,
                'questionId' => 1,
            ],
            [
                'id' => 2,
                'serviceId' => 1,
                'questionId' => 2,
            ],
            [
                'id' => 3,
                'serviceId' => 1,
                'questionId' => 3,
            ],
            [
                'id' => 4,
                'serviceId' => 1,
                'questionId' => 4,
            ],
            [
                'id' => 5,
                'serviceId' => 1,
                'questionId' => 5,
            ],
        ]);
    }
}
