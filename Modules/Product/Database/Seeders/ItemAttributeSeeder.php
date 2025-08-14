<?php

namespace Modules\Product\Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\File;
use Modules\Product\Entities\Item;
use Modules\Product\Entities\ItemAttribute;
use Modules\Product\Entities\ItemAttributeImage;

class ItemAttributeSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();
        $items = Item::all();
        $sizes = ['S', 'M', 'L', 'XL'];
        $colors = ['#A3BEF8', '#FFD58A', '#83B18B', '#4078FF', '#F25C54', '#FBBF24', '#A3BEF8', '#FFD58A', '#83B18B', '#4078FF', '#F25C54', '#FBBF24' , '#A3BEF8', '#FFD58A', '#83B18B', '#4078FF', '#F25C54', '#FBBF24'];
        $imagePath = module_path("Product", 'Resources/assets/Images');
        $images = File::files($imagePath);

        if (empty($images)) {
            throw new \Exception("No images found in directory: {$imagePath}");
        }

        foreach ($items as $item) {
            for ($i = 0; $i < $faker->numberBetween(2, 4); $i++) {
                try {
                    $item_attrib= ItemAttribute::create([
                        'item_id' => $item->id, // Auto-increment ID from Item
                        'color'  => $faker->randomElement($colors),
                        'size'   => $faker->randomElement($sizes),
                        'amount' => $faker->numberBetween(10, 100)
                    ]);
                }
                catch (UniqueConstraintViolationException $e) {
                    log("Duplicate entry for item_id: {$item->id}, color: {$item_attrib->color}, size: {$item_attrib->size}. Skipping this attribute.");
                    continue;
                }


                for ($k = 0; $k < fake()->numberBetween(1, 5); $k++) {
                    $randomImage = $images[array_rand($images)];
                    ItemAttributeImage::create([
                        'item_attribute_id' => $item_attrib->id, // Assuming item_id is used for associating images
                        'image' => 'items/' . $randomImage->getFilename(),
                    ]);
                }
            }
        }
    }
}
