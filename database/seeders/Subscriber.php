<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class Subscriber extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        DB::table('subscribers')->insert([
            'user_id' => '1',
            'subscription_id' => '1',
            'status' => 'Free',
            'admin_id' =>'1',
            'start_at' => '',
            'stopped_at' => ''
        ]);
        DB::table('subscribers')->insert([
            'user_id' => '2',
            'subscription_id' => '2',
            'status' => 'Premium',
            'admin_id' =>'2',
            'start_at' => '',
            'stopped_at' => ''
        ]);
    }
}
