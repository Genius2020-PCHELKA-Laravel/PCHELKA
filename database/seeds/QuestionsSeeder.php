<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades;

class QuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('questions')->delete();
        DB::table('questions')->insert([
            [
                'id' => 1,
                'name' => 'Frequency',
                'type' => 1,
                'price' => 0
            ],
            [
                'id' => 2,
                'name' => 'How many hours do you need your cleaner to stay',
                'type' => 1,
                'price' => 0
            ],
        ]);
    }
}
