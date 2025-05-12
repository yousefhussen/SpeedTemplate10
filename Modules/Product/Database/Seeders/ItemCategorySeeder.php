<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Product\Entities\Item;
use Modules\Product\Entities\Category;
use Faker\Factory;

class ItemCategorySeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();
        $items = Item::all();
        $categories = Category::pluck('id');

        foreach ($items as $item) {
            $item->categories()->attach(
                $faker->randomElements(
                    $categories->toArray(),
                    $faker->numberBetween(1, 3)
                )
            );
        }
    }
}
