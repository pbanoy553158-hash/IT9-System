<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Supplier;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $adminStats = [
            'total_suppliers'   => Supplier::count(),
            'active_orders'     => Order::whereIn('status', ['Processing','Pending','Shipped'])->count(),
            'total_revenue'     => Order::where('status','Delivered')->sum('total_amount'),
            'pending_approvals' => Order::where('status','Pending')->count(),
        ];

        // RECENT ACTIVITY
        $recentActivity = Order::with('user')
            ->latest()
            ->take(6)
            ->get();

        // WEEKLY ORDERS (MON–SUN)
        $startOfWeek = Carbon::now()->startOfWeek(Carbon::MONDAY);

        $weeklyOrders = [];

        for ($i = 0; $i < 7; $i++) {
            $date = $startOfWeek->copy()->addDays($i);

            $weeklyOrders[] = Order::whereDate('created_at', $date)->count();
        }

        $chartData = [
            Order::where('status','Delivered')->count(),
            Order::where('status','Pending')->count(),
            Order::where('status','Rejected')->count(),
        ];

        return view('admin.dashboard', compact(
            'adminStats',
            'recentActivity',
            'weeklyOrders',
            'chartData'
        ));
    }

    
    /*CLEAR RECENT ACTIVITY*/
    public function clearActivity()
    {
        Order::query()->update([
            'status' => 'Archived'
        ]);

        return back()->with('success', 'Activity cleared successfully.');
    }
}