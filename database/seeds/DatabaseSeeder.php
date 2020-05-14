<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        $this->call(ServicesSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(QuestionsSeeder::class);
        $this->call(QuestionDetailsSeeder::class);
        $this->call(ServiceProvidersSeeder::class);
        //$this->call(BookingsSeeder::class);
        $this->call(EvaluationsSeeder::class);
        $this->call(ServicesQuestionsSeeder::class);
        $this->call(OAuthSeeder::class);
    }
}
