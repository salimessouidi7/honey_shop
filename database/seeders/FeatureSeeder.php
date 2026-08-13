<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    public function run(): void
    {
        Feature::updateOrCreate(
            ['key' => 'comments'],
            [
                'name'        => 'Product Comments & Feedback',
                'description' => 'Lets logged-in customers leave a rating and written feedback on product pages.',
                'enabled'     => false,
            ]
        );
    }
}
