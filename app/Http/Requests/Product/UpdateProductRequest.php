<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends BaseProductRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return array_merge($this->commonRules(), [
            'name' => [
                'required', 
                'string', 
                'min:3', 
                'max: 100', 
                Rule::unique('products')->ignore($this->product)
            ],
        ]);
    }
}
