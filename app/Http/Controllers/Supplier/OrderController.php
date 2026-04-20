<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Show supplier orders (only current logged-in supplier)
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('supplier.orders.index', compact('orders'));
    }

    /**
     * Show order creation form
     */
    public function create()
    {
        return view('supplier.orders.create');
    }

    /**
     * Store new order (FIXED: supplier_id properly linked)
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'quantity'     => 'required|integer|min:1',
            'unit_price'   => 'required|numeric|min:0',
            'priority'     => 'required|in:standard,high,critical',
            'notes'        => 'nullable|string|max:1000',
        ]);

        Order::create([
            'user_id' => Auth::id(),

            // 🔥 THIS IS THE MOST IMPORTANT FIX
            'supplier_id' => Auth::user()->supplier_id,

            'product_name' => $request->product_name,
            'quantity'     => $request->quantity,
            'priority'     => $request->priority,
            'notes'        => $request->notes,

            // auto compute total
            'total_amount' => $request->quantity * $request->unit_price,

            // default status
            'status' => 'Pending',
        ]);

        return redirect()
            ->route('supplier.orders.index')
            ->with('success', 'Order successfully created.');
    }

    /**
     * Admin: view all orders
     */
    public function adminIndex()
    {
        $orders = Order::with(['user', 'supplier'])
            ->latest()
            ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Admin: update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:Pending,Processing,Shipped,Delivered,Rejected'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Order status updated successfully.');
    }

    /**
     * Admin: approve order
     */
    public function approve(Order $order)
    {
        $order->update([
            'approval_status' => 'Approved',
            'status' => 'Processing',
        ]);

        return back()->with('success', 'Order approved successfully.');
    }

    /**
     * Admin: reject order
     */
    public function reject(Order $order)
    {
        $order->update([
            'approval_status' => 'Rejected',
            'status' => 'Rejected',
        ]);

        return back()->with('success', 'Order rejected successfully.');
    }

    /**
     * Admin: delete order
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return back()->with('success', 'Order deleted successfully.');
    }
}