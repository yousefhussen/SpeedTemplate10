<?php

namespace Modules\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Product\Entities\Item;
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
            ->when($request->category, function ($query, $category) {
                $query->whereHas('categories', function ($q) use ($category) {
                    $q->where('name', $category);
                });
            })
            ->when($request->color, function ($query, $color) {
                $query->whereHas('attributes', function ($q) use ($color) {
                    $q->where('color', $color);
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
            ->with(['attributes', 'categories']) // Eager load relationships
            ->paginate(5); // Paginate results

        return new ItemResourceCollection($items);
    }
}
