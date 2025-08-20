<?php
// File: Modules/Product/Http/Requests/ItemReviewsRequest.php

namespace Modules\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Product\Entities\Item;

class ItemReviewsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'item_id' => $this->route('item'), // or $this->item if using route model binding
            'sort_by' => $this->input('sort_by', 'newest'),
            'per_page' => $this->input('per_page', 10),
        ]);
    }
    
    public function rules()
    {
        return [
            'item_id' => 'required|exists:items,id',
            'sort_by' => 'sometimes|string|in:newest,oldest,highest_rating,lowest_rating',
            'per_page' => 'sometimes|integer|min:1|max:100',
        ];
    }


}
