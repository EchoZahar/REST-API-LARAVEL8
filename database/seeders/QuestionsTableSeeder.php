<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $data = [
            [
                'name' => $faker->name,
                'email' => $faker->email,
                'message' => $faker->text(250),
                'created_at' => '2021-07-01 11:20:53',
                'updated_at' => '2021-07-01 11:20:53'
            ],
            [
                'name' => $faker->name,
                'email' => $faker->email,
                'message' => $faker->text(250),
                'created_at' => '2021-07-02 11:20:53',
                'updated_at' => '2021-07-02 11:20:53'
            ],
            [
                'name' => $faker->name,
                'email' => $faker->email,
                'message' => $faker->text(250),
                'created_at' => '2021-07-03 11:20:53',
                'updated_at' => '2021-07-03 11:20:53'
            ],
            [
                'name' => $faker->name,
                'email' => $faker->email,
                'message' => $faker->text(250),
                'created_at' => '2021-07-04 11:20:53',
                'updated_at' => '2021-07-04 11:20:53'
            ],
            [
                'name' => $faker->name,
                'email' => $faker->email,
                'message' => $faker->text(250),
                'created_at' => '2021-07-05 11:20:53',
                'updated_at' => '2021-07-05 11:20:53'
            ]
        ];

        DB::table('questions')->insert($data);
    }
}
