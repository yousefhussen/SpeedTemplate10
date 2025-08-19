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

    public function rules()
    {
        return [];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $item = Item::find($this->route('item'));

            if (!$item) {
                $validator->errors()->add('item', 'Item not found');
            }
        });
    }
}
