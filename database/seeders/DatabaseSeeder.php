<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(User_Seeder::class);
        $this->call(Admins_Seeder::class);
        $this->call(Stores_Seeder::class);
        $this->call(Category_Seeder::class);
        $this->call(Product_Seeder::class);
        $this->call(Aboutus_Seeder::class);

    }
}
