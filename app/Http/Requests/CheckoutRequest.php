<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:25'],
            'whatsapp' => ['nullable', 'string', 'max:25'],
            'email' => ['nullable', 'email', 'max:120'],
            'order_type' => ['required', 'in:delivery,pickup'],
            'address' => ['required_if:order_type,delivery', 'nullable', 'string', 'max:255'],
            'city' => ['required_if:order_type,delivery', 'nullable', 'string', 'max:100'],
            'state' => ['required_if:order_type,delivery', 'nullable', 'string', 'max:50'],
            'zip_code' => ['required_if:order_type,delivery', 'nullable', 'string', 'max:20'],
            'delivery_instructions' => ['nullable', 'string', 'max:500'],
            'order_notes' => ['nullable', 'string', 'max:500'],
            'payment_method' => ['required', 'in:Cash on Delivery,Pay at Pickup'],
        ];
    }

    public function messages(): array
    {
        return [
            'address.required_if' => 'A street address is required for delivery orders.',
            'city.required_if' => 'City is required for delivery orders.',
            'state.required_if' => 'State is required for delivery orders.',
            'zip_code.required_if' => 'ZIP code is required for delivery orders.',
        ];
    }
}