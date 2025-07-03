<?php

namespace App\Actions\Stocks;

use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class GetStocks
{
    public function handle(Request $request): LengthAwarePaginator
    {
        // Pagination settings
        $page = $request->get('page', 1);
        $perPage = 15;

       $groups = DB::table('stocks')
            ->select(
                'stocks.product_id',
                'products.name as product_name',
                DB::raw('SUM(stocks.quantity) as current_stock'),
                DB::raw('SUM(CASE WHEN stocks.type = "sale" THEN stocks.quantity ELSE 0 END) as sold'),
                DB::raw('MAX(stocks.date) as date'),
                DB::raw('MAX(stocks.created_at) as created_at')
            )
            ->join('products', 'products.id', '=', 'stocks.product_id')
            ->groupBy('stocks.product_id', 'products.name')
            ->orderByDesc(DB::raw('MAX(stocks.created_at)'))
            ->get();

        return new LengthAwarePaginator(
            $groups->slice(($page - 1) * $perPage, $perPage)->values(),
            $groups->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );
    }
}