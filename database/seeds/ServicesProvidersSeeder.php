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

        for ($i = 1; $i < 13; $i++) {
            for ($j = 1; $j < 11; $j++) {
                DB::table('providerservices')->insert([
                    'service_id' => $i,
                    'provider_id' => $j,
                ]);
            }
        }


    }
}
