<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. ADMIN VIEW LOGIC
        if ($user->role === 'admin') {
            $adminStats = [
                'total_suppliers'   => User::where('role', 'supplier')->count(),
                'active_orders'     => Order::whereIn('status', ['Processing', 'Shipped'])->count(),
                'pending_approvals' => Order::where('status', 'Pending')->count(),
                'total_revenue'     => Order::where('status', 'Delivered')->sum('total_amount'),
            ];

            $chartData = [
                'Pending'    => Order::where('status', 'Pending')->count(),
                'Processing' => Order::where('status', 'Processing')->count(),
                'Shipped'    => Order::where('status', 'Shipped')->count(),
                'Delivered'  => Order::where('status', 'Delivered')->count(),
                'Rejected'   => Order::where('status', 'Rejected')->count(),
            ];

            $recentActivity = Order::with('user')->latest()->take(5)->get();

            // Variables are defined HERE, so compact works here
            return view('admin.dashboard', compact('adminStats', 'chartData', 'recentActivity'));
        }

        // 2. SUPPLIER VIEW LOGIC
        $stats = [
            'total'     => Order::where('user_id', $user->id)->count(),
            'pending'   => Order::where('user_id', $user->id)->where('status', 'Pending')->count(),
            'shipped'   => Order::where('user_id', $user->id)->where('status', 'Shipped')->count(),
            'delivered' => Order::where('user_id', $user->id)->where('status', 'Delivered')->count(),
        ];

        $recent_orders = Order::where('user_id', $user->id)
            ->latest()
            ->take(6)
            ->get();

        // Admin variables are NOT needed here, so we only compact supplier variables
        return view('supplier.dashboard', compact('stats', 'recent_orders'));
    }
}