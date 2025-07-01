<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return view('stocks.index', [
            'stocks' => Stock::query()->with('product')->latest()->paginate(15)
        ]);
    }
}
