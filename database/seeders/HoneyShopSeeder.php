<?php

namespace Database\Seeders;

use App\Models\Catalog;
use App\Models\Product;
use Illuminate\Database\Seeder;

class HoneyShopSeeder extends Seeder
{
    public function run(): void
    {
        $wildflower = Catalog::create([
            'name' => 'Wildflower Honey',
            'description' => 'Honey made from a mix of wildflower nectar.',
        ]);

        $acacia = Catalog::create([
            'name' => 'Acacia Honey',
            'description' => 'Light, mild honey from acacia blossoms.',
        ]);

        $raw = Catalog::create([
            'name' => 'Raw Honey',
            'description' => 'Unfiltered, unpasteurized honey straight from the hive.',
        ]);

        Product::create([
            'catalog_id' => $wildflower->id,
            'name' => 'Wildflower Honey Jar 500g',
            'honey_type' => 'Wildflower',
            'description' => "A rich, floral honey harvested from wildflower meadows.\nGreat for tea and baking.",
            'price' => 12.99,
            'stock' => 25,
            'image_url' => null,
        ]);

        Product::create([
            'catalog_id' => $acacia->id,
            'name' => 'Acacia Honey Jar 500g',
            'honey_type' => 'Acacia',
            'description' => "Light and mild, this honey stays liquid longer than most varieties.",
            'price' => 15.99,
            'stock' => 15,
            'image_url' => null,
        ]);

        Product::create([
            'catalog_id' => $raw->id,
            'name' => 'Raw Honey Jar 500g',
            'honey_type' => 'Raw',
            'description' => "Straight from the hive, unfiltered and unpasteurized for maximum natural flavor.",
            'price' => 17.99,
            'stock' => 10,
            'image_url' => null,
        ]);
    }
}
