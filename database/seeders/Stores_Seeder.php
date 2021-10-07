<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class Stores_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        foreach (range(1, 3) as $value) {
            DB::table('stores')->insert([
                'name' =>$faker->company,
                'address' =>$faker->address,
                'user_id' => 1,
            ]);
        }
    }
}
