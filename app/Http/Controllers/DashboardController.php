<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Activity;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | ADMIN DASHBOARD
        |--------------------------------------------------------------------------
        */
        if ($user->role === 'admin') {

            $adminStats = [
                'total_suppliers' => User::where('role', 'supplier')->count(),
                'active_orders' => Order::count(),
                'pending_approvals' => Order::where('status', 'Pending')->count(),
            ];

            $recentActivity = Order::with('user')
                ->latest()
                ->take(10)
                ->get();

            $weeklyOrders = [4, 10, 8, 15, 12, 18, 22];

            $chartData = [
                Order::where('status', 'Pending')->count(),
                Order::where('status', 'Processing')->count(),
                Order::where('status', 'Delivered')->count(),
            ];

            return view('admin.dashboard', compact(
                'adminStats',
                'recentActivity',
                'weeklyOrders',
                'chartData'
            ));
        }

        /*
        |--------------------------------------------------------------------------
        | SUPPLIER DASHBOARD
        |--------------------------------------------------------------------------
        */
        $stats = [
            'total' => Order::where('user_id', $user->id)->count(),
            'pending' => Order::where('user_id', $user->id)->where('status', 'Pending')->count(),
            'shipped' => Order::where('user_id', $user->id)->where('status', 'Shipped')->count(),
            'delivered' => Order::where('user_id', $user->id)->where('status', 'Delivered')->count(),
        ];

        $recent_orders = Order::where('user_id', $user->id)
            ->latest()
            ->take(6)
            ->get();

        $activities = Activity::where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get();

        return view('supplier.dashboard', compact(
            'stats',
            'recent_orders',
            'activities'
        ));
    }
}