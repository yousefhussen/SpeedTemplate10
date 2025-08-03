<?php

namespace Modules\Product\Database\Seeders;


use Illuminate\Database\Seeder;
use Modules\Product\Entities\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {

        $categories = ['Men', 'Women', 'Kids', 'Accessories', 'Shoes'];
        $categories_images=[
            'C1.png',
            'C2.png',
            'C3.png',
            'C4.png',
            'C5.png'
        ];

        foreach ($categories as $index => $category) {
            Category::create([
                'name'  => $category,
                'image' => $categories_images[$index] ?? null
            ]);
        }
    }
}
