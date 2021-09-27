<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;


class Product_Seeder extends Seeder
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
            DB::table('products')->insert([
               'name' => $faker->randomElement(['Skincare', 'Palu', 'Beras']),
               'store_id'=> rand(1,3),
               'category_id'=> rand(1,3),
               'image' =>$faker->text,
               'price'=>$faker->randomDigit(),
               'stock'=> $faker->randomDigit(),
               'barcode'=>$faker->randomDigit(),
            ]);
        }
    }
}
