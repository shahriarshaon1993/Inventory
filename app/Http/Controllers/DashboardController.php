<?php

namespace App\Http\Controllers;

use App\Actions\Reports\CalculateProfit;
use App\Models\Journal;
use App\Models\SaleItem;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, CalculateProfit $action)
    {
        $from = $request->input('from');
        $to = $request->input('to');

        $reports = $action->handle($from, $to);

        // Return JSON for AJAX requests
        if ($request->ajax()) {
            return response()->json($reports);
        }

        // Return view for initial page load
        return view('dashboard', [
            'profit' => $reports['profit'],
            'totalSale' => $reports['totalSale'],
            'totalExpense' => $reports['totalExpense'],
        ]);
    }
}
