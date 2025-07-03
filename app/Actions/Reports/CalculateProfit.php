<?php

declare(strict_types=1);

namespace App\Actions\Reports;

use App\Models\Journal;
use App\Models\SaleItem;

final class CalculateProfit
{
    /**
     * Calculate profit, sale, expenses.
     */
    public function handle(?string $from, ?string $to): array
    {
        $journalQuery = Journal::query();
        $saleItemQuery = SaleItem::with('product')->whereHas('sale');

        if ($from && $to) {
            $journalQuery->whereBetween('date', [$from, $to]);

            $saleItemQuery->whereHas('sale', function ($q) use ($from, $to) {
                $q->whereBetween('date', [$from, $to]);
            });
        }

        $totalSales = $journalQuery->clone()->where('type', 'sale')->sum('amount');
        $totalDiscount = $journalQuery->clone()->where('type', 'discount')->sum('amount');
        $totalVat = $journalQuery->clone()->where('type', 'vat')->sum('amount');

        // COGS by (Sale Items × Purchase Price)
        $saleItems = $saleItemQuery->get();
        $totalCOGS = $saleItems->sum(function (SaleItem $item) {
            return $item->quantity * ($item->product->purchase_price ?? 0);
        });

        $totalExpenses = $totalDiscount + $totalVat + $totalCOGS;
        $profit = $totalSales - $totalExpenses;

        return [
            'profit' => $profit,
            'totalSale' => $totalSales,
            'totalExpense' => $totalExpenses,
        ];
    }
}
