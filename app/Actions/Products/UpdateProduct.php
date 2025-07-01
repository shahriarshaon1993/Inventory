<?php

namespace App\Actions\Products;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class UpdateProduct
{
    public function handle(Product $product, array $attributes): Product
    {
        return DB::transaction(function () use ($product, $attributes): Product {
            $product->update($attributes);

            if ($product->current_stock > 0) {
                $product->stocks()->update([
                    'quantity' => $product->current_stock,
                    'price' => $product->purchase_price,
                ]);

                $product->journals()
                    ->where('type', 'opening')
                    ->update([
                        'amount' => $product->current_stock * $product->purchase_price,
                    ]);
            }

            return $product;
        });
    }
}