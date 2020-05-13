<?php

use Illuminate\Database\Seeder;

class QuestionDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('question_details')->delete();
        DB::table('question_details')->insert([
            [
                'id' => 1,
                'name' => 'One-time',
                'price' => 0,
                'questionId' => 1
            ],
            [
                'id' => 2,
                'name' => 'Bi-weekly',
                'price' => 0,
                'questionId' => 1
            ],
            [
                'id' => 3,
                'name' => 'Weekly',
                'price' => 0,
                'questionId' => 1
            ],
            [
                'id' => 4,
                'name' => '2',
                'price' => 50,
                'questionId' => 2
            ],
            [
                'id' => 5,
                'name' => '3',
                'price' => 100,
                'questionId' => 2
            ],
            [
                'id' => 6,
                'name' => '4',
                'price' => 150,
                'questionId' => 2
            ],
            [
                'id' => 7,
                'name' => '5',
                'price' => 200,
                'questionId' => 2
            ],
            [
                'id' => 8,
                'name' => '6',
                'price' => 250,
                'questionId' => 2
            ],
            [
                'id' => 9,
                'name' => '7',
                'price' => 300,
                'questionId' => 2
            ],
            [
                'id' => 10,
                'name' => '1',
                'price' => 50,
                'questionId' => 3
            ],
            [
                'id' => 11,
                'name' => '2',
                'price' => 100,
                'questionId' => 3
            ],
            [
                'id' => 12,
                'name' => '3',
                'price' => 150,
                'questionId' => 3
            ],
            [
                'id' => 13,
                'name' => '4',
                'price' => 200,
                'questionId' => 3
            ],
            [
                'id' => 14,
                'name' => 'No , I have them',
                'price' => 0,
                'questionId' => 4
            ],
            [
                'id' => 15,
                'name' => 'Yes , Please',
                'price' => 100,
                'questionId' => 4
            ],
            [
                'id' => 16,
                'name' => 'More request value',
                'price' => 0,
                'questionId' => 5
            ],
        ]);
    }
}
