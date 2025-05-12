<?php

namespace Modules\Product\Database\Seeders;


use Illuminate\Database\Seeder;
use Modules\Product\Entities\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {


        $categories = ['Men', 'Women', 'Kids', 'Accessories', 'Shoes'];

        foreach ($categories as $category) {
            Category::create([
                'name'  => $category
            ]);
        }
    }
}
