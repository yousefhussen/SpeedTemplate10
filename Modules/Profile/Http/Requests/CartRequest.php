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
            'user_id' => 'required|exists:users,id',

        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
