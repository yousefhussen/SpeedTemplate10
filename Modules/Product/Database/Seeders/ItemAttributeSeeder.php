<?php

namespace Modules\Product\Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Modules\Product\Entities\Item;
use Modules\Product\Entities\ItemAttribute;

class ItemAttributeSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();
        $items = Item::all();
        $sizes = ['S', 'M', 'L', 'XL'];
        $colors = ['#A3BEF8', '#FFD58A', '#83B18B', '#4078FF', '#F25C54', '#FBBF24', '#A3BEF8', '#FFD58A', '#83B18B', '#4078FF', '#F25C54', '#FBBF24'];

        foreach ($items as $item) {
            for ($i = 0; $i < $faker->numberBetween(2, 4); $i++) {
                ItemAttribute::create([
                    'itemId' => $item->id, // Auto-increment ID from Item
                    'color'  => $faker->randomElement($colors),
                    'size'   => $faker->randomElement($sizes),
                    'amount' => $faker->numberBetween(10, 100)
                ]);
            }
        }
    }
}
