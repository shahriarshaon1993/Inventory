<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Products\CreateProduct;
use App\Actions\Products\UpdateProduct;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

final class ProductController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $products = Product::query()
            ->latest()->paginate(15);

        return view('products.index', [
            'products' => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request, CreateProduct $action): RedirectResponse
    {
        try {
            $action->handle($request->validated());

            return Redirect::route('products.index')
                ->with('success', 'Product has been created successfully!');
        } catch (Exception $e) {
            return Redirect::route('products.index')
                ->with('error', 'Failed to create product: '.$e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {
        return view('products.edit', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product, UpdateProduct $action): RedirectResponse
    {
        try {
            $action->handle($product, $request->validated());

            return back()->with('success', 'Product has been updated successfully!');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to create product: '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        if ($product->stocks()->exists()) {
            return back()->with([
                'woring' => 'Cannot delete product with stock history.',
            ]);
        }

        $product->delete();

        return back()->with('success', 'Product has been deleted successfully!');
    }
}
