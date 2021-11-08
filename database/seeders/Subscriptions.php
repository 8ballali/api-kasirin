<?php

namespace Database\Seeders;

use App\Models\Subsrciption;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Subscriptions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create('id_ID');

        DB::table('subscriptions')->insert([
            'name' => 'Trial',
            'description' => 'Free Trial for New User',
            'image' => '',
            'price' => $faker->randomDigit(),
            'duration' => 10
        ]);
        DB::table('subscriptions')->insert([
            'name' => 'Silver',
            'description' => 'Paket Silver memiliki durasi 3 bulan',
            'image' => '',
            'price' => $faker->randomDigit(),
            'duration' => 30
        ]);

    }
}
