<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Modules\Product\Entities\Item;

class ItemSeeder extends Seeder
{
    public function run()
    {
        // Path to your local images directory
        $imagePath = module_path("Product",'Resources/assets/Images'); // Change this to your actual path
        $images = File::files($imagePath);

        // Ensure there are images available
        if (empty($images)) {
            throw new \Exception("No images found in directory: {$imagePath}");
        }

        for ($i = 0; $i < 9; $i++) {
            // Get random image from your collection
            $randomImage = $images[array_rand($images)];

            Item::create([
                'name' => fake()->unique()->words(3, true),
                'brand' => fake()->company,
                'price' => fake()->randomFloat(2, 20, 200),
                'image' => 'items/' . $randomImage->getFilename(), // Store relative path
                'totalRating' => fake()->randomFloat(1, 0, 5)
            ]);
        }
    }
}
