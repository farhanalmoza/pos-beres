<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('stores')->insert([
            [
                'name' => 'Toko Sembako Jaya',
                'address' => 'Jl. Merdeka No.123, Jakarta Pusat, DKI Jakarta',
            ],
            [
                'name' => 'Minimarket Sejahtera',
                'address' => 'Jl. Sudirman No.456, Bandung, Jawa Barat',
            ],
            [
                'name' => 'Supermarket Makmur',
                'address' => 'Jl. Ahmad Yani No.789, Surabaya, Jawa Timur',
            ],
            [
                'name' => 'Grosir Maju Bersama',
                'address' => 'Jl. Gajah Mada No.101, Semarang, Jawa Tengah',
            ],
            [
                'name' => 'Warung Bu Ani',
                'address' => 'Jl. Diponegoro No.202, Yogyakarta, DI Yogyakarta',
            ],
        ]);
    }
}
