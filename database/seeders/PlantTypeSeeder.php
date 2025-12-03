<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PlantType;

class PlantTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['title' => 'fruit plants'],
            ['title' => 'coniferous plants'],
            ['title' => 'ornamental plants'],
        ];

        foreach ($types as $type) {
            PlantType::create($type);
        }
    }
}
