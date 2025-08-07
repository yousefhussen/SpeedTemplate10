<?php

namespace Modules\Payment\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class  ProcessPaymentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'amount_cents' => 'required|numeric|min:0.01',
            'currency' => 'required|string|max:3|in:EGP', // For Now only EGP is supported
            'payment_method' => 'required|string',
            'description' => 'nullable|string|max:255',
            'customer_email' => 'required|email',
            'customer_first_name' => 'nullable|string|max:100',
            'customer_last_name' => 'nullable|string|max:100',
            'shipping_data' => 'nullable|array',
            'shipping_data.address_line_1' => 'required|string|max:255',
            'shipping_data.address_line_2' => 'nullable|string|max:100',
            'shipping_data.city' => 'required|string|max:100',
            'shipping_data.state' => 'required|string|max:100',
            'shipping_data.postal_code' => 'required|string|max:20',
            'shipping_data.country' => 'required|string|max:100',
            'shipping_data.phone_number' => 'required|string|max:20',

        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
