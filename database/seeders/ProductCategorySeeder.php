<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Engine Parts', 'slug' => Str::slug('Engine Parts')],
            ['name' => 'Braking System', 'slug' => Str::slug('Braking System')],
            ['name' => 'Electrical System', 'slug' => Str::slug('Electrical System')],
            ['name' => 'Transmission', 'slug' => Str::slug('Transmission')],
            ['name' => 'Suspension', 'slug' => Str::slug('Suspension')],
            ['name' => 'Tires', 'slug' => Str::slug('Tires')],
        ];

        foreach ($categories as $category) {
            ProductCategory::create($category);
        }
    }
}
