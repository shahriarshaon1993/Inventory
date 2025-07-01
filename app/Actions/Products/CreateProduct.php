<?php

namespace App\Actions\Products;

use App\Models\Journal;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CreateProduct
{
    /**
     * Store a newly created product.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function handle(array $attributes): Product
    {
        return DB::transaction(function () use ($attributes): Product {
            $product = Product::create($attributes);

            if ($product->current_stock > 0) {
                $product->stocks()->create([
                    'date' => now()->toDateString(),
                    'type' => 'opening',
                    'quantity' => $product->current_stock,
                    'price' => $product->purchase_price,
                ]);

                $product->journals()->create([
                    'date' => now()->toDateString(),
                    'type' => 'opening',
                    'amount' => $product->current_stock * $product->purchase_price,
                    'reference_type' => Product::class,
                    'reference_id' => $product->id,
                ]);
            }

            return $product;
        });
    }
}