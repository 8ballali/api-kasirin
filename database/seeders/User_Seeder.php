<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class User_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'fcm_token' => $faker->regexify('[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}'),
            'address' => $faker->address,
            'gender' =>$faker->randomElement(['Male', 'Female']),
            'avatar'=>'',
            'phone' => $faker->e164PhoneNumber,
            'password' => Hash::make('12345678'),
        ]);
    }
}
