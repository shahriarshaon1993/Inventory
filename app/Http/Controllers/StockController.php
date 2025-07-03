<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Stocks\GetStocks;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class StockController
{
    /**
     * Handle the incoming request.
     */
    public function index(Request $request, GetStocks $action): View
    {
        $stocks = $action->handle($request);

        return view('stocks.index', [
            'groups' => $stocks,
        ]);
    }
}
