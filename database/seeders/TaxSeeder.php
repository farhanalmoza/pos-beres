<?php

namespace Database\Seeders;

use App\Models\Tax;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // check if taxes table is empty
        if (Tax::count() == 0) {
            Tax::create([
                'tax' => 0,
            ]);
        }
    }
}
