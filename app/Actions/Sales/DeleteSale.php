<?php

namespace App\Actions\Sales;

use App\Models\Journal;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Stock;

class DeleteSale
{
    public function handle(Sale $sale): void
    {
        // Reverse stock updates
        $saleItems = SaleItem::where('sale_id', $sale->id)->get();

        foreach ($saleItems as $item) {
            $product = $item->product;
            $product->increment('current_stock', $item->quantity);

            Stock::create([
                'product_id' => $item->product_id,
                'date' => now(),
                'type' => 'reversal',
                'price' => $product->purchase_price,
                'quantity' => $item->quantity,
            ]);
        }

        // Delete journal records
        Journal::where('reference_type', Sale::class)
                ->where('reference_id', $sale->id)
                ->delete();

        // Delete the sale
        $sale->delete();
    }
}