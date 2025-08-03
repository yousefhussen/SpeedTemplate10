<?php

namespace Modules\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Product\Entities\Category;
use Modules\Product\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function index()
    {

        // Fetch all categories from the database
        $categories = Category::all();

        // Return the categories as a JSON response
        return CategoryResource::collection(
            $categories
        );
    }
}
