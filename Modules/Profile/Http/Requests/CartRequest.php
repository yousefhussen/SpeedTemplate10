<?php

namespace Modules\Profile\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Product\Entities\ItemAttribute;

class CartRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'item_attributes_id' => 'required|exists:item_attributes,id',
            'quantity' => 'required|integer|min:1',

        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
