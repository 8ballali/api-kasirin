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
            'name' => 'Free',
            'price' => 0,
        ]);
        DB::table('subscriptions')->insert([
            'name' => 'Premium',
            'price' => 100000,
        ]);

    }
}
