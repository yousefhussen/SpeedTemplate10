<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Modules\Product\Entities\Item;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\ItemAttribute;
use Modules\Product\Entities\ItemAttributeImage;

class ItemSeeder extends Seeder
{
    public function run()
    {
        $imagePath = module_path("Product", 'Resources/assets/Images');
        $images = File::files($imagePath);

        if (empty($images)) {
            throw new \Exception("No images found in directory: {$imagePath}");
        }

        $categories = Category::pluck('id')->toArray();

        for ($i = 0; $i < 9; $i++) {
            $item = Item::create([
                'name' => fake()->unique()->words(3, true),
                'brand' => fake()->company,
                'totalRating' => fake()->randomFloat(1, 0, 5),
                'image' => 'items/' . $images[array_rand($images)]->getFilename(),
            ]);

            $item->categories()->attach(
                fake()->randomElements($categories, fake()->numberBetween(1, 3))
            );


        }
    }
}
