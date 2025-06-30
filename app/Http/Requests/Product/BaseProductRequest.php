<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

abstract class BaseProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function commonRules(): array
    {
        return [
            'purchase_price' => ['required', 'string'],
            'sell_price' => ['required', 'string'],
            'opening_stock' => ['required', 'integer'],
            'current_stock' => ['required', 'integer'],
        ];
    }
}
