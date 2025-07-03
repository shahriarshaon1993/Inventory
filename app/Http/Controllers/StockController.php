<?php

namespace App\Http\Controllers;

use App\Actions\Stocks\GetStocks;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Request $request, GetStocks $action)
    {
        $stocks = $action->handle($request);

        return view('stocks.index', [
            'groups' => $stocks,
        ]);
    }
}
