<?php

namespace App\Http\Controllers;

use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SaleItemController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        return view('sale_items.index', [
            'salesItems' => SaleItem::query()
                ->with(['product', 'sale'])
                ->latest()->paginate(15)
        ]);
    }
}
