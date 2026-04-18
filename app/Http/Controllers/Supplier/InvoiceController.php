<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display list of supplier's invoices with improved UI
     */
    public function index(Request $request)
    {
        $query = Order::where('user_id', Auth::id())->latest();

        // Simple search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('product_name', 'like', "%{$search}%");
            });
        }

        $orders = $query->paginate(10);

        return view('supplier.invoices.index', compact('orders'));
    }

    /**
     * Show single invoice
     */
    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this invoice.');
        }

        return view('supplier.invoices.show', compact('order'));
    }
}