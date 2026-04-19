<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // KPI STATS
        $adminStats = [
            'total_suppliers'   => Supplier::count(),
            'active_orders'     => Order::whereIn('status', ['Processing','Pending','Shipped'])->count(),
            'total_revenue'     => Order::where('status','Delivered')->sum('total_price'),
            'pending_approvals' => Order::where('status','Pending')->count(),
        ];

        // RECENT ACTIVITY
        $recentActivity = Order::with('user')->latest()->take(6)->get();

        // 🔥 WEEKLY ORDERS (REAL DATA)
        $startOfWeek = Carbon::now()->startOfWeek();

        $weeklyOrdersRaw = Order::select(
                DB::raw('DAYOFWEEK(created_at) as day'),
                DB::raw('COUNT(*) as total')
            )
            ->whereBetween('created_at', [$startOfWeek, now()])
            ->groupBy('day')
            ->pluck('total','day');

        // Map to MON-SUN
        $weeklyOrders = [];
        for ($i = 2; $i <= 8; $i++) {
            $dayIndex = $i == 8 ? 1 : $i;
            $weeklyOrders[] = $weeklyOrdersRaw[$dayIndex] ?? 0;
        }

        // 🔥 SYSTEM HEALTH
        $chartData = [
            Order::where('status','Delivered')->count(),
            Order::where('status','Pending')->count(),
            Order::where('status','Cancelled')->count(),
        ];

        return view('admin.dashboard', compact(
            'adminStats',
            'recentActivity',
            'weeklyOrders',
            'chartData'
        ));
    }
}