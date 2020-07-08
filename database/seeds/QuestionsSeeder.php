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
            #region HomeCleaning
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
            [
                'id' => 3,
                'name' => 'How many Cleaners do you need',
                'type' => 1,
                'price' => 0
            ],
            [
                'id' => 4,
                'name' => 'Do you require cleaning materials',
                'type' => 1,
                'price' => 0
            ],
            [
                'id' => 5,
                'name' => 'More request',
                'type' => 1,
                'price' => 0
            ],
            #endregion
            #region Disinfection
            [
                'id' => 6,
                'name' => 'How many hours do you need your cleaner to stay',
                'type' => 1,
                'price' => 0
            ],
            [
                'id' => 7,
                'name' => 'How many Cleaners do you need',
                'type' => 1,
                'price' => 0
            ],
            [
                'id' => 8,
                'name' => 'Do you require cleaning materials',
                'type' => 1,
                'price' => 0
            ],
            #endregion
            #region DeepCleaning
            [
                'id' => 9,
                'name' => 'How many hours do you need your cleaner to stay',
                'type' => 1,
                'price' => 0
            ],
            [
                'id' => 10,
                'name' => 'How many Cleaners do you need',
                'type' => 1,
                'price' => 0
            ],
            [
                'id' => 11,
                'name' => 'Do you require cleaning materials',
                'type' => 1,
                'price' => 0
            ],
            #endregion
            #region BabysitterService
            [
                'id' => 12,
                'name' => 'How many hours do you need your cleaner to stay',
                'type' => 1,
                'price' => 0
            ],
            [
                'id' => 13,
                'name' => 'How many Cleaners do you need',
                'type' => 1,
                'price' => 0
            ],
            [
                'id' => 14,
                'name' => 'Do you require cleaning materials',
                'type' => 1,
                'price' => 0
            ],
            #endregion
            #region FullTimeMaid
            [
                'id' => 15,
                'name' => 'Do you want the maid to live with you',
                'type' => 1,
                'price' => 0
            ],
            [
                'id' => 16,
                'name' => 'How long do you need the full-time maid for',
                'type' => 1,
                'price' => 0
            ],
            #endregion
            #region CarWash
            [
                'id' => 17,
                'name' => 'Type of Vehicle',
                'type' => 1,
                'price' => 0
            ],
            [
                'id' => 18,
                'name' => 'Select add-ons',
                'type' => 1,
                'price' => 0
            ],
            #endregion
            #region ACCleaning
            [
                'id' => 19,
                'name' => 'What type of AC cleaning ',
                'type' => 1,
                'price' => 0
            ],
            [
                'id' => 20,
                'name' => 'Number of AC Controllers/Remotes',
                'type' => 1,
                'price' => 0
            ],
            #endregion
            #region SofaCleaning
            [
                'id' => 21,
                'name' => 'What type of sofa(s) or chairs(s) would you like to clean ',
                'type' => 1,
                'price' => 0
            ],
            [
                'id' => 22,
                'name' => 'Number of chair/1-seater sofas',
                'type' => 1,
                'price' => 0
            ],
            [
                'id' => 23,
                'name' => 'Number of chair/2-seater sofas',
                'type' => 1,
                'price' => 0
            ],
            [
                'id' => 24,
                'name' => 'Number of chair/3-seater sofas',
                'type' => 1,
                'price' => 0
            ],
            [
                'id' => 25,
                'name' => 'Number of chair/4-seater sofas',
                'type' => 1,
                'price' => 0
            ],
            [
                'id' => 26,
                'name' => 'Number of chair/5-seater sofas',
                'type' => 1,
                'price' => 0
            ],
            #endregion
            #region MattressCleaning
            [
                'id' => 27,
                'name' => 'Number of single bed ',
                'type' => 1,
                'price' => 0
            ],

            #endregion

            #region CurtainCleaning
            [
                'id' => 28,
                'name' => 'quantity',
                'type' => 1,
                'price' => 0
            ],
            [
                'id' => 29,
                'name' => 'Total square meters ',
                'type' => 1,
                'price' => 0
            ],
            #endregion

            #region CarpetCleaning
            [
                'id' => 30,
                'name' => 'quantity',
                'type' => 1,
                'price' => 0
            ],
            #endregion
        ]);
    }
}
