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
            ->when($request->quick_search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('brand', 'like', '%' . $search . '%')
                    ->limit(5);
            })
            ->when(!$request->quick_search, function ($query) use ($request) {
                // Always apply filters first
                $query->when($request->categories, fn($query, $categories)
                => $this->filterByCategories($query, $categories))
                    ->when($request->color, fn($query, $color)
                    => $this->filterByColor($query, $color))
                    ->when($request->size, fn($query, $size)
                    => $this->filterBySize($query, $size))
                    ->when($request->min_price, fn($query, $minPrice)
                    => $query->whereHas('attributes', fn($q) => $q->where('price', '>=', $minPrice)))
                    ->when($request->max_price, fn($query, $maxPrice)
                    => $query->whereHas('attributes', fn($q) => $q->where('price', '<=', $maxPrice)));

                // Then apply search WITHIN the filtered results
                $query->when($request->search, function ($query, $search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%')
                            ->orWhere('brand', 'like', '%' . $search . '%');
                    });
                });

                // Finally apply sorting and relationships
                $query->when($request->sort_by, fn($query, $sortBy)
                => $this->applySorting($query, $sortBy, $request->sort_order))
                    ->with(['attributes', 'categories']);
            })
            ->paginate(8);

        return new ItemResourceCollection($items);
    }

//show
    public function show($id)
    {
        $item = Item::with(['attributes', 'categories'])->findOrFail($id);
        return new ItemResource($item);
    }
    private function filterByCategories($query, $categories)
    {
        $categoriesArray = is_array($categories) ? $categories : explode(',', $categories);
        $query->whereHas('categories', fn($q) => $q->whereIn('name', $categoriesArray));
    }

    private function filterByColor($query, $color)
    {
        $colors = is_array($color) ? $color : explode(',', $color);
        $query->whereHas('attributes', fn($q) => $q->whereIn('color', $colors));
    }

    private function filterBySize($query, $size)
    {
        $query->whereHas('attributes', fn($q) => $q->where('size', $size));
    }

    private function applySorting($query, $sortBy, $sortOrder)
    {
        $sortOrder = $sortOrder === 'desc' ? 'desc' : 'asc'; // Default to 'asc' if not provided
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
