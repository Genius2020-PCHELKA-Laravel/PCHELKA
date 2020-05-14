<?php

use Illuminate\Database\Seeder;

class OAuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('oauth_personal_access_clients')->delete();
        DB::table('oauth_personal_access_clients')->insert([
            [
                'id' => 1,
                'client_id' => 1,
                'created_at' =>now(),
                'updated_at' =>now(),
            ]
        ]);
        DB::table('oauth_clients')->delete();
        DB::table('oauth_clients')->insert([
            [
                'id' => '1',
                'name' => 'PCHELKA-Backend',
                'secret' => 'LaYN8jvxdLLFbmm3fdVdGiZEwzcqNoZDopxof0uC',
                'redirect' => 'http://localhost',
                'personal_access_client' => 1,
                'password_client' => 1,
                'revoked' => 0,
                'created_at' =>now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
