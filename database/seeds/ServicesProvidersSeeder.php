<?php

use Illuminate\Database\Seeder;

class ServicesProvidersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('providerservices')->delete();
        DB::table('providerservices')->insert([
            [
                'service_id' => 1,
                'provider_id' => 1,
            ],
            [
                'service_id' => 1,
                'provider_id' => 2,
            ],
            [
                'service_id' => 2,
                'provider_id' => 1,
            ],
            [
                'service_id' => 3,
                'provider_id' => 2,
            ],
            [
                'service_id' => 3,
                'provider_id' => 3,
            ],
            [
                'service_id' => 3,
                'provider_id' => 4,
            ],

        ]);
    }
}
