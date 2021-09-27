<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class Aboutus_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach (range(1, 3) as $value) {
            DB::table('abouts')->insert([
                'content' =>$faker->text(),
                'title' => $faker->randomElement(['Kasirin1', 'Kasirin2', 'Kasirin3']),
                'type' =>$faker->randomElement(['pemberitahuan', 'peringatan', 'reward']),
            ]);
        }
    }
}
