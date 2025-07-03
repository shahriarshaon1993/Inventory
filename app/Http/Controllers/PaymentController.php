<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class PaymentController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        return view('payments.index', [
            'payments' => Payment::query()->with('sale')
                ->latest()->paginate(15),
        ]);
    }
}
