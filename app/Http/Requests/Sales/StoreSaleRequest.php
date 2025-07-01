<?php

namespace App\Http\Requests\Sales;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class StoreSaleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'date' => ['required', 'date'],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'vat' => ['required', 'numeric', 'min:0'],
            'paid_amount' => ['nullable', 'numeric', 'min:0'],

            'products' => ['required', 'array', 'min:1'],
            'products.*.product_id' => ['required', 'exists:products,id'],
            'products.*.quantity' => ['required', 'integer', 'min:1'],
            'products.*.unit_price' => ['required', 'numeric', 'min:0.01'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'date.required' => 'The date field is required.',
            'date.date' => 'The date must be a valid date format.',

            'discount.numeric' => 'The discount must be a number.',
            'discount.min' => 'The discount cannot be negative.',

            'vat.required' => 'The VAT field is required.',
            'vat.numeric' => 'The VAT must be a number.',
            'vat.min' => 'The VAT cannot be negative.',

            'paid_amount.numeric' => 'The paid amount must be a number.',
            'paid_amount.min' => 'The paid amount cannot be negative.',

            'products.required' => 'At least one product is required.',
            'products.array' => 'The products must be provided as an array.',
            'products.min' => 'At least one product must be included.',

            'products.*.product_id.required' => 'The product ID is required for each product.',
            'products.*.product_id.exists' => 'The selected product ID is invalid.',

            'products.*.quantity.required' => 'The quantity is required for each product.',
            'products.*.quantity.integer' => 'The quantity must be a whole number.',
            'products.*.quantity.min' => 'The quantity must be at least 1.',

            'products.*.unit_price.required' => 'The unit price is required for each product.',
            'products.*.unit_price.numeric' => 'The unit price must be a number.',
            'products.*.unit_price.min' => 'The unit price must be at least 0.01.',
        ];
    }
}
