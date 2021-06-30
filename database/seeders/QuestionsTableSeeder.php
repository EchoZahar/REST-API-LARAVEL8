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
            ],
            [
                'name' => $faker->name,
                'email' => $faker->email,
                'message' => $faker->text(250),
            ],
            [
                'name' => $faker->name,
                'email' => $faker->email,
                'message' => $faker->text(250),
            ],
            [
                'name' => $faker->name,
                'email' => $faker->email,
                'message' => $faker->text(250),
            ],
            [
                'name' => $faker->name,
                'email' => $faker->email,
                'message' => $faker->text(250),
            ]
        ];

        DB::table('questions')->insert($data);
    }
}
