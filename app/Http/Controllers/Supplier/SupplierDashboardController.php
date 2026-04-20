<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Activity;

class SupplierDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total' => Order::count(),
            'pending' => Order::where('status', 'Pending')->count(),
            'shipped' => Order::where('status', 'Shipped')->count(),
            'delivered' => Order::where('status', 'Delivered')->count(),
        ];

        $recent_orders = Order::latest()->take(5)->get(); 

        $activities = Activity::latest()->take(10)->get();

        return view('supplier.dashboard', compact(
            'stats',
            'recent_orders',
            'activities'
        ));
    }
}