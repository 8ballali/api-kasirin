<?php

namespace Database\Seeders;

use App\Models\Admin;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class Admins_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'email' => 'admin@gmail.com',
            'password' => Hash::make(12345678)
        ]);
        Admin::create([
            'email' => 'admin1@gmail.com',
            'password' => Hash::make(12345678)
        ]);
        Admin::create([
            'email' => 'admin2@gmail.com',
            'password' => Hash::make(12345678)
        ]);
    }
}
