<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Reports\CalculateProfit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class DashboardController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, CalculateProfit $action): JsonResponse|View
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
