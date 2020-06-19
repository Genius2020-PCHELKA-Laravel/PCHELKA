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
            #region HomeCleaning
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
            #endregion
            #region Disinfection
            [
                'id' => 6,
                'serviceId' => 11,
                'questionId' => 1,
            ], [
                'id' => 7,
                'serviceId' => 11,
                'questionId' => 6,
            ], [
                'id' => 8,
                'serviceId' => 11,
                'questionId' => 7,
            ], [
                'id' => 9,
                'serviceId' => 11,
                'questionId' => 4,
            ],
            [
                'id' => 10,
                'serviceId' => 11,
                'questionId' => 5,
            ],
            #endregion
            #region DeepCleaning
            [
                'id' => 11,
                'serviceId' => 7,
                'questionId' => 1,
            ], [
                'id' => 12,
                'serviceId' => 7,
                'questionId' => 9,
            ], [
                'id' => 13,
                'serviceId' => 7,
                'questionId' => 10,
            ], [
                'id' => 14,
                'serviceId' => 7,
                'questionId' => 4,
            ],
            [
                'id' => 15,
                'serviceId' => 7,
                'questionId' => 5,
            ],
            #endregion
            #region BabysitterService
            [
                'id' => 16,
                'serviceId' => 12,
                'questionId' => 1,
            ], [
                'id' => 17,
                'serviceId' => 12,
                'questionId' => 12,
            ], [
                'id' => 18,
                'serviceId' => 12,
                'questionId' => 13,
            ],
            [
                'id' => 20,
                'serviceId' => 12,
                'questionId' => 5,
            ],
            #endregion
            #region FullTimeMaid
            [
                'id' => 21,
                'serviceId' => 10,
                'questionId' => 15,
            ], [
                'id' => 22,
                'serviceId' => 10,
                'questionId' => 16,
            ],
            [
                'id' => 23,
                'serviceId' => 10,
                'questionId' => 5,
            ],
            #endregion
            #region CarWash
            [
                'id' => 24,
                'serviceId' => 8,
                'questionId' => 17,
            ], [
                'id' => 25,
                'serviceId' => 8,
                'questionId' => 18,
            ],
            [
                'id' => 26,
                'serviceId' => 8,
                'questionId' => 5,
            ],
            #endregion
            #region ACCleaning
            [
                'id' => 27,
                'serviceId' => 2,
                'questionId' => 19,
            ], [
                'id' => 28,
                'serviceId' => 2,
                'questionId' => 20,
            ],
            [
                'id' => 29,
                'serviceId' => 2,
                'questionId' => 5,
            ],
            #endregion
            #region SofaCleaning
            [
                'id' => 31,
                'serviceId' => 6,
                'questionId' => 22,
            ],
            [
                'id' => 35,
                'serviceId' => 6,
                'questionId' => 4,
            ],
            [
                'id' => 36,
                'serviceId' => 6,
                'questionId' => 5,
            ],
            #endregion
            #region MattressCleaning
            [
                'id' => 37,
                'serviceId' => 5,
                'questionId' => 27,
            ],
            [
                'id' => 40,
                'serviceId' => 5,
                'questionId' => 4,
            ],
            [
                'id' => 41,
                'serviceId' => 5,
                'questionId' => 5,
            ],
            #endregion
            #region CurtainCleaning
            [
                'id' => 42,
                'serviceId' => 3,
                'questionId' => 28,
            ],
            [
                'id' => 43,
                'serviceId' => 3,
                'questionId' => 29,
            ],
            [
                'id' => 44,
                'serviceId' => 3,
                'questionId' => 4,
            ],
            [
                'id' => 45,
                'serviceId' => 5,
                'questionId' => 5,
            ],
            #endregion
            #region CarpetCleaning
            [
                'id' => 46,
                'serviceId' => 4,
                'questionId' => 30,
            ],
            [
                'id' => 47,
                'serviceId' => 4,
                'questionId' => 29,
            ],
            [
                'id' => 48,
                'serviceId' => 4,
                'questionId' => 4,
            ],
            [
                'id' => 49,
                'serviceId' => 4,
                'questionId' => 5,
            ],
            #endregion
        ]);
    }
}
