<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller

{
    public function index()
    {
        $products = Product::latest()->get();
        $totalQuantity = $products->sum('quantity');

        return Inertia::render('Products/Index', [
            'products' => $products,
            'totalQuantity' => $totalQuantity,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        $data['total'] = $data['quantity'] * $data['price'];
        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Product added.');
    }
};