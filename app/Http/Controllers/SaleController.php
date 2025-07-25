<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Sales\CreateSale;
use App\Actions\Sales\DeleteSale;
use App\Http\Requests\Sales\StoreSaleRequest;
use App\Models\Product;
use App\Models\Sale;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

final class SaleController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $sales = Sale::query()
            ->latest()->paginate(15);

        return view('sales.index', [
            'sales' => $sales,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('sales.create', [
            'products' => Product::query()->latest()->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSaleRequest $request, CreateSale $action): RedirectResponse
    {
        try {
            $action->handle($request->validated());

            return Redirect::route('sales.index')
                ->with('success', 'Sale has been created successfully!');
        } catch (Exception $e) {
            return Redirect::route('sales.index')
                ->with('error', 'Failed to create sale: '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale, DeleteSale $action): RedirectResponse
    {
        try {
            $action->handle($sale);

            return back()->with('success', 'Sale has been deleted successfully!');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to delete sale: '.$e->getMessage());
        }
    }
}
