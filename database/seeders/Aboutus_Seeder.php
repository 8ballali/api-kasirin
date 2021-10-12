<?php

namespace Database\Seeders;

use App\Models\About;
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
        $faker = Faker::create('id_ID');
        About::create([
            'content' => 'Ini Adalah Isi Untuk Content About us',
            'title' => 'About Us',
            'type' => 'About us',
        ]);
    }
}
