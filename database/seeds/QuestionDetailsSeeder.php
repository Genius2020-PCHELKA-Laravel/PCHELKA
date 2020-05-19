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
            #region HomeCleaning
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
            #endregion
            #region Disinfection

            [
                'id' => 17,
                'name' => '2',
                'price' => 50,
                'questionId' => 6
            ],
            [
                'id' => 18,
                'name' => '3',
                'price' => 100,
                'questionId' => 6
            ],
            [
                'id' => 19,
                'name' => '4',
                'price' => 150,
                'questionId' => 6
            ],
            [
                'id' => 20,
                'name' => '5',
                'price' => 200,
                'questionId' => 6
            ],
            [
                'id' => 21,
                'name' => '6',
                'price' => 250,
                'questionId' => 6
            ],
            [
                'id' => 22,
                'name' => '7',
                'price' => 300,
                'questionId' => 6
            ],
            [
                'id' => 23,
                'name' => '1',
                'price' => 50,
                'questionId' => 7
            ],
            [
                'id' => 24,
                'name' => '2',
                'price' => 100,
                'questionId' => 7
            ],
            [
                'id' => 25,
                'name' => '3',
                'price' => 150,
                'questionId' => 7
            ],
            [
                'id' => 26,
                'name' => '4',
                'price' => 200,
                'questionId' => 7
            ],
            [
                'id' => 27,
                'name' => 'No , I have them',
                'price' => 0,
                'questionId' => 8
            ],
            [
                'id' => 28,
                'name' => 'Yes , Please',
                'price' => 100,
                'questionId' => 8
            ],

            #endregion
            #region DeepCleaning
            [
                'id' => 29,
                'name' => '2',
                'price' => 50,
                'questionId' => 9
            ],
            [
                'id' => 30,
                'name' => '3',
                'price' => 100,
                'questionId' => 9
            ],
            [
                'id' => 31,
                'name' => '4',
                'price' => 150,
                'questionId' => 9
            ],
            [
                'id' => 32,
                'name' => '5',
                'price' => 200,
                'questionId' => 9
            ],
            [
                'id' => 33,
                'name' => '6',
                'price' => 250,
                'questionId' => 9
            ],
            [
                'id' => 34,
                'name' => '7',
                'price' => 300,
                'questionId' => 9
            ],
            [
                'id' => 35,
                'name' => '1',
                'price' => 50,
                'questionId' => 10
            ],
            [
                'id' => 36,
                'name' => '2',
                'price' => 100,
                'questionId' => 10
            ],
            [
                'id' => 37,
                'name' => '3',
                'price' => 150,
                'questionId' => 10
            ],
            [
                'id' => 38,
                'name' => '4',
                'price' => 200,
                'questionId' => 10
            ],
            [
                'id' => 39,
                'name' => 'No , I have them',
                'price' => 0,
                'questionId' => 11
            ],
            [
                'id' => 40,
                'name' => 'Yes , Please',
                'price' => 100,
                'questionId' => 11
            ],

            #endregion
            #region BabysitterService
            [
                'id' => 41,
                'name' => '2',
                'price' => 50,
                'questionId' => 12
            ],
            [
                'id' => 42,
                'name' => '3',
                'price' => 100,
                'questionId' => 12
            ],
            [
                'id' => 43,
                'name' => '4',
                'price' => 150,
                'questionId' => 12
            ],
            [
                'id' => 44,
                'name' => '5',
                'price' => 200,
                'questionId' => 12
            ],
            [
                'id' => 45,
                'name' => '6',
                'price' => 250,
                'questionId' => 12
            ],
            [
                'id' => 46,
                'name' => '7',
                'price' => 300,
                'questionId' => 12
            ],
            [
                'id' => 47,
                'name' => '1',
                'price' => 50,
                'questionId' => 13
            ],
            [
                'id' => 48,
                'name' => '2',
                'price' => 100,
                'questionId' => 13
            ],
            [
                'id' => 49,
                'name' => '3',
                'price' => 150,
                'questionId' => 13
            ],
            [
                'id' => 50,
                'name' => '4',
                'price' => 200,
                'questionId' => 13
            ],
            [
                'id' => 51,
                'name' => 'No , I have them',
                'price' => 0,
                'questionId' => 14
            ],
            [
                'id' => 52,
                'name' => 'Yes , Please',
                'price' => 100,
                'questionId' => 14
            ],
            #endregion
            #region FullTimeMaid
            [
                'id' => 53,
                'name' => 'live-in',
                'price' => 50,
                'questionId' => 15
            ],
            [
                'id' => 54,
                'name' => 'live-out',
                'price' => 100,
                'questionId' => 15
            ],
            [
                'id' => 55,
                'name' => '1 week',
                'price' => 150,
                'questionId' => 16
            ],
            [
                'id' => 56,
                'name' => '2 week',
                'price' => 200,
                'questionId' => 16
            ],
            [
                'id' => 57,
                'name' => '1 month',
                'price' => 250,
                'questionId' => 16
            ],
            #endregion
            #region CarWash
            [
                'id' => 58,
                'name' => 'Sedan',
                'price' => 50,
                'questionId' => 17
            ],
            [
                'id' => 59,
                'name' => 'SUV',
                'price' => 100,
                'questionId' => 17
            ],
            [
                'id' => 60,
                'name' => 'Super Shine',
                'price' => 150,
                'questionId' => 18
            ],
            [
                'id' => 61,
                'name' => 'Extreme Body Wash',
                'price' => 200,
                'questionId' => 18
            ],
            #endregion
            #region ACCleaning
            [
                'id' => 62,
                'name' => 'AC regular Cleaning',
                'price' => 50,
                'questionId' => 19
            ],
            [
                'id' => 63,
                'name' => 'AC Deep Cleaning(Duct)',
                'price' => 100,
                'questionId' => 19
            ],
            [
                'id' => 64,
                'name' => 'AC Deep Cleaning(Coil)',
                'price' => 100,
                'questionId' => 19
            ],
            [
                'id' => 65,
                'name' => '1',
                'price' => 100,
                'questionId' => 20
            ],
            [
                'id' => 66,
                'name' => '2',
                'price' => 100,
                'questionId' => 20
            ],
            [
                'id' => 67,
                'name' => '3',
                'price' => 100,
                'questionId' => 20
            ],
            [
                'id' => 68,
                'name' => '4',
                'price' => 100,
                'questionId' => 20
            ],
            [
                'id' => 69,
                'name' => '5',
                'price' => 100,
                'questionId' => 20
            ],
            [
                'id' => 70,
                'name' => '6',
                'price' => 100,
                'questionId' => 20
            ],
            #endregion
            #region SofaCleaning
            [
                'id' => 71,
                'name' => 'Leather',
                'price' => 50,
                'questionId' => 21
            ],
            [
                'id' => 72,
                'name' => 'Fabric/Suede',
                'price' => 100,
                'questionId' => 21
            ],
            [
                'id' => 73,
                'name' => 'Mixed',
                'price' => 100,
                'questionId' => 21
            ],
            [
                'id' => 74,
                'name' => '0',
                'price' => 100,
                'questionId' => 22
            ],
            [
                'id' => 75,
                'name' => '1',
                'price' => 100,
                'questionId' => 22
            ],
            [
                'id' => 76,
                'name' => '2',
                'price' => 100,
                'questionId' => 22
            ],
            [
                'id' => 77,
                'name' => '3',
                'price' => 100,
                'questionId' => 22
            ],
            [
                'id' => 78,
                'name' => '4',
                'price' => 100,
                'questionId' => 22
            ],
            [
                'id' => 79,
                'name' => '5',
                'price' => 100,
                'questionId' => 22
            ],
            [
                'id' => 80,
                'name' => '0',
                'price' => 100,
                'questionId' => 23
            ],
            [
                'id' => 81,
                'name' => '1',
                'price' => 100,
                'questionId' => 23
            ],
            [
                'id' => 82,
                'name' => '2',
                'price' => 100,
                'questionId' => 23
            ],
            [
                'id' => 83,
                'name' => '3',
                'price' => 100,
                'questionId' => 23
            ],
            [
                'id' => 84,
                'name' => '4',
                'price' => 100,
                'questionId' => 23
            ],
            [
                'id' => 85,
                'name' => '5',
                'price' => 100,
                'questionId' => 23
            ],
            [
                'id' => 86,
                'name' => '0',
                'price' => 100,
                'questionId' => 24
            ],
            [
                'id' => 87,
                'name' => '1',
                'price' => 100,
                'questionId' => 24
            ],
            [
                'id' => 88,
                'name' => '2',
                'price' => 100,
                'questionId' => 24
            ],
            [
                'id' => 89,
                'name' => '3',
                'price' => 100,
                'questionId' => 24
            ],
            [
                'id' => 90,
                'name' => '4',
                'price' => 100,
                'questionId' => 24
            ],
            [
                'id' => 91,
                'name' => '5',
                'price' => 100,
                'questionId' => 24
            ],
            [
                'id' => 92,
                'name' => '0',
                'price' => 100,
                'questionId' => 25
            ],
            [
                'id' => 93,
                'name' => '1',
                'price' => 100,
                'questionId' => 25
            ],
            [
                'id' => 94,
                'name' => '2',
                'price' => 100,
                'questionId' => 25
            ],
            [
                'id' => 95,
                'name' => '3',
                'price' => 100,
                'questionId' => 25
            ],
            [
                'id' => 96,
                'name' => '4',
                'price' => 100,
                'questionId' => 25
            ],
            [
                'id' => 97,
                'name' => '5',
                'price' => 100,
                'questionId' => 25
            ],
            [
                'id' => 98,
                'name' => '0',
                'price' => 100,
                'questionId' => 26
            ],
            [
                'id' => 99,
                'name' => '1',
                'price' => 100,
                'questionId' => 26
            ],
            [
                'id' => 100,
                'name' => '2',
                'price' => 100,
                'questionId' => 26
            ],
            [
                'id' => 101,
                'name' => '3',
                'price' => 100,
                'questionId' => 26
            ],
            [
                'id' => 102,
                'name' => '4',
                'price' => 100,
                'questionId' => 26
            ],
            [
                'id' => 103,
                'name' => '5',
                'price' => 100,
                'questionId' => 26
            ],

            #endregion
            #region MattressCleaning
            [
                'id' => 104,
                'name' => '0',
                'price' => 100,
                'questionId' => 27
            ],
            [
                'id' => 105,
                'name' => '1',
                'price' => 100,
                'questionId' => 27
            ],
            [
                'id' => 106,
                'name' => '2',
                'price' => 100,
                'questionId' => 27
            ],
            [
                'id' => 107,
                'name' => '3',
                'price' => 100,
                'questionId' => 27
            ],
            [
                'id' => 108,
                'name' => '4',
                'price' => 100,
                'questionId' => 27
            ],
            [
                'id' => 109,
                'name' => '5',
                'price' => 100,
                'questionId' => 27
            ],
            [
                'id' => 110,
                'name' => '0',
                'price' => 100,
                'questionId' => 28
            ],
            [
                'id' => 111,
                'name' => '1',
                'price' => 100,
                'questionId' => 28
            ],
            [
                'id' => 112,
                'name' => '2',
                'price' => 100,
                'questionId' => 28
            ],
            [
                'id' => 113,
                'name' => '3',
                'price' => 100,
                'questionId' => 28
            ],
            [
                'id' => 114,
                'name' => '4',
                'price' => 100,
                'questionId' => 28
            ],
            [
                'id' => 115,
                'name' => '5',
                'price' => 100,
                'questionId' => 28
            ],
            [
                'id' => 116,
                'name' => '0',
                'price' => 100,
                'questionId' => 29
            ],
            [
                'id' => 117,
                'name' => '1',
                'price' => 100,
                'questionId' => 29
            ],
            [
                'id' => 118,
                'name' => '2',
                'price' => 100,
                'questionId' => 29
            ],
            [
                'id' => 119,
                'name' => '3',
                'price' => 100,
                'questionId' => 29
            ],
            [
                'id' => 120,
                'name' => '4',
                'price' => 100,
                'questionId' => 29
            ],
            [
                'id' => 121,
                'name' => '5',
                'price' => 100,
                'questionId' => 29
            ],
            [
                'id' => 122,
                'name' => '0',
                'price' => 100,
                'questionId' => 30
            ],
            [
                'id' => 123,
                'name' => '1',
                'price' => 100,
                'questionId' => 30
            ],
            [
                'id' => 124,
                'name' => '2',
                'price' => 100,
                'questionId' => 30
            ],
            [
                'id' => 125,
                'name' => '3',
                'price' => 100,
                'questionId' => 30
            ],
            [
                'id' => 126,
                'name' => '4',
                'price' => 100,
                'questionId' => 30
            ],
            [
                'id' => 127,
                'name' => '5',
                'price' => 100,
                'questionId' => 30
            ],
            #endregion
        ]);
    }
}
