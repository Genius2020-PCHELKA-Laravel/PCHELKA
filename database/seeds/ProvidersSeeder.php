<?php

use Illuminate\Database\Seeder;

class ProvidersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('providers')->delete();
        DB::table('providers')->insert([
            [
                'id' => 1,
                'name' => 'Belal',
                'email' => "B@b.c",
                'mobileNumber' => '0994665567',
                'imageUrl' => '1',
                'companyId' => null
            ],
            [
                'id' => 2,
                'name' => 'mohamad',
                'email' => "m@m.c",
                'mobileNumber' => '0994665567',
                'imageUrl' => '2',
                'companyId' => null
            ],
        ]);
    }
}
