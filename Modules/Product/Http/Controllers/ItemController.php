<?php

namespace Modules\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Product\Entities\Item;
use Modules\Product\Entities\ItemAttribute;
use Modules\Product\Http\Resources\ItemResource;
use Modules\Product\Http\Resources\ItemResourceCollection;

class ItemController extends Controller
{
    /**
     * Filter items by attributes/categories.
     *
     * @param Request $request
     * @return ItemResourceCollection
     */
    public function index(Request $request)
    {
        $items = Item::query()
            ->when($request->categories, function ($query, $categories) {
                $categoriesArray = is_array($categories) ? $categories : explode(',', $categories); // Handle array or comma-separated string
                $query->whereHas('categories', function ($q) use ($categoriesArray) {
                    $q->whereIn('name', $categoriesArray); // Use whereIn for multiple categories
                });
            })
            ->when($request->color, function ($query, $color) {
                $colors = is_array($color) ? $color : explode(',', $color); // Handle array or comma-separated string
                $query->whereHas('attributes', function ($q) use ($colors) {
                    $q->whereIn('color', $colors); // Use whereIn for "or" relation
                });
            })
            ->when($request->size, function ($query, $size) {
                $query->whereHas('attributes', function ($q) use ($size) {
                    $q->where('size', $size);
                });
            })
            ->when($request->min_price, function ($query, $minPrice) {
                $query->where('price', '>=', $minPrice);
            })
            ->when($request->max_price, function ($query, $maxPrice) {
                $query->where('price', '<=', $maxPrice);
            })
            ->when($request->sort_by, function ($query, $sortBy) use ($request) {
                $sortOrder = $request->sort_order === 'desc' ? 'desc' : 'asc'; // Default to 'asc' if not provided
                switch ($sortBy) {
                    case 'price':
                        $query->orderBy('price', $sortOrder);
                        break;
                    case 'name':
                        $query->orderBy('name', $sortOrder);
                        break;
                    case 'most_recent':
                        $query->orderBy('created_at', $sortOrder);
                        break;
                    case 'totalRating':
                        $query->orderBy('totalRating', $sortOrder);
                        break;
                }
            })
            ->with(['attributes', 'categories']) // Eager load relationships
            ->paginate(8); // Paginate results

        return new ItemResourceCollection($items);
    }


    public function  getColors()
    {
        $colors = ItemAttribute::distinct()->pluck('color');
        return response()->json($colors);
    }

    public function getSizes()
    {
        $sizes = ItemAttribute::distinct()->pluck('size');
        return response()->json($sizes);
    }
}
