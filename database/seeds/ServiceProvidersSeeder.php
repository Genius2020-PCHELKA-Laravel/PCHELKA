<?php

use Illuminate\Database\Seeder;

class ServiceProvidersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('service_providers')->delete();
        DB::table('service_providers')->insert([
            [
                'id' => 1,
                'name' => 'Belal',
                'email' => "B@b.c",
                'mobileNumber' =>'0994665567',
                'type' => 1,
            ],
            [
                'id' => 2,
                'name' => 'mohamad',
                'email' => "m@m.c",
                'mobileNumber' =>'0994665567',
                'type' => 1,
            ],
        ]);
    }
}
