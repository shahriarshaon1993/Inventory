<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return view('payments.index', [
            'payments' => Payment::query()->with('sale')
                    ->latest()->paginate(15)
        ]);
    }
}
