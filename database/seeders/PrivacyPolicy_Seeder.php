<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class PrivacyPolicy_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('privacy_policy')->insert([
            'content' => 'Aplikasi ini dilengkapi dengan potongan pertransaksi dan stok untuk produk, sehingga anda bisa mudah memonitor produk-produk anda. Aplikasi dikembangkan oleh Dokter Apps. Semua data pengguna hanya disimpan di penyimpanan lokal di gadget masing-masing. Kami tidak mengambil data apapun untuk kepentingan kami. Semua data tersimpan lokal termasuk foto yang digunakan untuk produk.'
        ]);
    }
}
