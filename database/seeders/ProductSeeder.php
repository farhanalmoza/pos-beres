<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil ID kategory dari berdasarkan slug
        $enginePartsId = ProductCategory::where('slug', '=', 'engine-parts')->first()->id;
        $brakingSystemId = ProductCategory::where('slug', '=', 'braking-system')->first()->id;
        $electricalSystemId = ProductCategory::where('slug', '=', 'electrical-system')->first()->id;
        $transmissionId = ProductCategory::where('slug', '=', 'transmission')->first()->id;
        $suspensionId = ProductCategory::where('slug', '=', 'suspension')->first()->id;
        $tiresId = ProductCategory::where('slug', '=', 'tires')->first()->id;

        $products = [
            ['code' => 'ENG001', 'name' => 'Piston', 'slug' => Str::slug('Piston'), 'category_id' => $enginePartsId, 'price' => 500000],
            ['code' => 'ENG002', 'name' => 'Oil Filer', 'slug' => Str::slug('Oil Filer'), 'category_id' => $enginePartsId, 'price' => 150000],
            ['code' => 'BRA001', 'name' => 'Brake Pad', 'slug' => Str::slug('Piston Rod'), 'category_id' => $brakingSystemId, 'price' => 250000],
            ['code' => 'BRA002', 'name' => 'Disc Brake', 'slug' => Str::slug('Disc Brake'), 'category_id' => $brakingSystemId, 'price' => 750000],
            ['code' => 'ELE001', 'name' => 'Battery', 'slug' => Str::slug('Battery'), 'category_id' => $electricalSystemId, 'price' => 800000],
            ['code' => 'ELE002', 'name' => 'Starter', 'slug' => Str::slug('Starter'), 'category_id' => $electricalSystemId, 'price' => 100000],
            ['code' => 'SUS001', 'name' => 'Front Suspension', 'slug' => Str::slug('Front Suspension'), 'category_id' => $suspensionId, 'price' => 100000],
            ['code' => 'TRA001', 'name' => 'Clutch', 'slug' => Str::slug('Clutch'), 'category_id' => $transmissionId, 'price' => 550000],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
