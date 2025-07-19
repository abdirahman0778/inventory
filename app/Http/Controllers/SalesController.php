<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Sale;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SalesController extends Controller
{
   public function index()
{
    return Inertia::render('Sales/Index', [
        'customers' => Customer::select('id', 'name')->get(),
        'products' => Product::select('id', 'name', 'price', 'quantity')->get(),
    ]);
}


    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->quantity < $request->quantity) {
            return back()->withErrors(['quantity' => 'Not enough stock available.']);
        }

        $total = $product->price * $request->quantity;

        Sale::create([
            'customer_id' => $request->customer_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'total_price' => $total,
        ]);

        $product->decrement('quantity', $request->quantity);

        return redirect()->route('Sales.Index')->with('success', 'Sale completed successfully.');
    }
}