<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()->get();
        return Inertia::render('Customers/index', compact('customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required',
            'address' => 'nullable|string',
        ]);

        Customer::create($validated);

        return redirect()->back()->with('success', 'Customer added successfully.');
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:customers,email,' . $id,
            'phone' => 'required',
            'address' => 'nullable|string',
        ]);

        $customer->update($validated);

        return redirect()->back()->with('success', 'Customer updated successfully.');
    }

    public function destroy($id)
    {
        Customer::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Customer deleted.');
    }
}
