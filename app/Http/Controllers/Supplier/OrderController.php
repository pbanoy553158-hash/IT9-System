<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->paginate(10);
        return view('supplier.orders.index', compact('orders'));
    }

    public function create()
    {
        return view('supplier.orders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'quantity'     => 'required|integer|min:1',
            'priority'     => 'required|in:standard,high,critical',
            'notes'        => 'nullable|string|max:1000',
        ]);

        Order::create([
            'user_id'      => Auth::id(),
            'product_name' => $request->product_name,
            'quantity'     => $request->quantity,
            'priority'     => $request->priority,
            'notes'        => $request->notes,
            'total_amount' => 0, 
        ]);

        return redirect()->route('supplier.orders.index')->with('success', "Transmission logged.");
    }

    public function adminIndex()
    {
        $orders = Order::with('user')->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:Pending,Processing,Shipped,Delivered,Rejected,Approved']);
        $order->update(['status' => $request->status]);
        return back()->with('success', "Status updated.");
    }
}