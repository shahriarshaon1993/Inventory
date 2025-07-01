<?php

namespace App\Actions\Sales;

use App\Models\Journal;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;

class CreateSale
{
    /**
     * Store a newly created sale.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function handle(array $attributes): Sale
    {
        return DB::transaction(function () use ($attributes): Sale {
            $saleData = $this->calculateSaleAmounts($attributes);
            $sale = $this->createSaleRecord($saleData);

            $this->createSaleItems($sale, $attributes['products'], $saleData['date']);

            if ($saleData['paid_amount'] > 0) {
                $this->createPayment($sale, $saleData);
            }

            $this->createJournalEntries($sale, $saleData);
            
            return $sale;
        });
    }

    /**
     * Calculate sale amounts
     * 
     * @param array $attributes
     * @return array
     */
    private function calculateSaleAmounts(array $attributes): array
    {
        $subtotal = array_sum(array_map(
            fn($product) => $product['quantity'] * $product['unit_price'],
            $attributes['products']
        ));

        $subtotalAfterDiscount = $subtotal - $attributes['discount'];
        $vatAmount = ($subtotalAfterDiscount * $attributes['vat']) / 100;
        $totalAmount = $subtotalAfterDiscount + $vatAmount;

        return [
            'vat' => $attributes['vat'],
            'date' => $attributes['date'],
            'subtotal' => $subtotal,
            'discount' => $attributes['discount'],
            'vat_amount' => $vatAmount,
            'total_amount' => $totalAmount,
            'paid_amount' => $attributes['paid_amount'],
            'due_amount' => $totalAmount - $attributes['paid_amount'],
        ];
    }

    /**
     * A new sales create.
     * 
     * @param array $saleData
     * @return Sale
     */
    private function createSaleRecord(array $saleData): Sale
    {
        return Sale::create([
            'vat' => $saleData['vat'],
            'date' => $saleData['date'],
            'subtotal' => $saleData['subtotal'],
            'discount' => $saleData['discount'],
            'vat_amount' => $saleData['vat_amount'],
            'total_amount' => $saleData['total_amount'],
            'paid_amount' => $saleData['paid_amount'],
            'due_amount' => $saleData['due_amount'] < 0 ? 0: $saleData['due_amount'],
        ]);
    }

    /**
     * Creare sale items
     * 
     * @param \App\Models\Sale $sale
     * @param array $products
     * @param string $date
     * @return void
     */
    private function createSaleItems(Sale $sale, array $products, string $date): void
    {
        foreach ($products as $item) {
            $product = Product::findOrFail($item['product_id']);
            
            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total' => $item['quantity'] * $item['unit_price'],
            ]);

            $this->updateProductStock($product, $item['quantity'], $date);
        }
    }

    /**
     * Manage product stocks
     * 
     * @param \App\Models\Product $product
     * @param int $quantity
     * @param string $date
     * @return void
     */
    private function updateProductStock(Product $product, int $quantity, string $date): void
    {
        $product->decrement('current_stock', $quantity);

        Stock::create([
            'product_id' => $product->id,
            'date' => $date,
            'type' => 'sale',
            'price' => $product->purchase_price,
            'quantity' => -1 * $quantity,
        ]);
    }

    /**
     * Create sale payment.
     * 
     * @param \App\Models\Sale $sale
     * @param array $saleData
     * @return void
     */
    private function createPayment(Sale $sale, array $saleData): void
    {
        Payment::create([
            'sale_id' => $sale->id,
            'date' => $saleData['date'],
            'amount' => $saleData['paid_amount'],
            'method' => 'cash'
        ]);
    }

    private function createJournalEntries(Sale $sale, array $saleData): void
    {
        $journalEntries = [
            [
                'date' => $saleData['date'],
                'type' => 'sale',
                'amount' => $saleData['subtotal'],
                'reference_type' => Sale::class,
                'reference_id' => $sale->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'date' => $saleData['date'],
                'type' => 'discount',
                'amount' => $saleData['discount'] < 0 ? 0: $saleData['discount'],
                'reference_type' => Sale::class,
                'reference_id' => $sale->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'date' => $saleData['date'],
                'type' => 'vat',
                'amount' => $saleData['vat_amount'],
                'reference_type' => Sale::class,
                'reference_id' => $sale->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'date' => $saleData['date'],
                'type' => 'payment',
                'amount' => $saleData['paid_amount'],
                'reference_type' => Sale::class,
                'reference_id' => $sale->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'date' => $saleData['date'],
                'type' => 'due',
                'amount' => $saleData['due_amount'] < 0 ? 0: $saleData['due_amount'],
                'reference_type' => Sale::class,
                'reference_id' => $sale->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert only non-zero entries
        Journal::insert(array_filter($journalEntries, fn($entry) => $entry['amount'] != 0));
    }
}