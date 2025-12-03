<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PlantProtectionProduct;

class PlantProtectionProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['title' => 'Actara'],
            ['title' => 'Ridomil Gold'],
            ['title' => 'Topaz'],
            ['title' => 'Konfidor Maxi'],
        ];

        foreach ($products as $product) {
            PlantProtectionProduct::create($product);
        }
    }
}
