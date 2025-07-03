<?php

declare(strict_types=1);

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

abstract class BaseProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    final public function commonRules(): array
    {
        return [
            'purchase_price' => ['required', 'string'],
            'sell_price' => ['required', 'string'],
            'opening_stock' => ['required', 'integer'],
            'current_stock' => ['required', 'integer'],
        ];
    }
}
