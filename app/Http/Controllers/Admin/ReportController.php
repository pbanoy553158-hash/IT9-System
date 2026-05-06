<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Reports Overview Dashboard
     */
    public function index()
    {
        $total_revenue = Order::where('status', 'Delivered')->sum('total_amount') ?? 0;
        $supplier_count = Supplier::count() ?? 0;
        $total_orders = Order::count() ?? 0;

        return view('admin.reports.index', compact(
            'total_revenue',
            'supplier_count',
            'total_orders'
        ));
    }

    /**
     * Supplier Performance Analytics Module
     */
    public function supplierPerformance()
    {
        // Summary metrics (Strictly integers/floats)
        $total_revenue = Order::where('status', 'Delivered')->sum('total_amount') ?? 0;
        $supplier_count = Supplier::count() ?? 0;
        $total_orders = Order::count() ?? 0;

        // Table Data (The only paginated collection)
        $supplier_performance = Supplier::leftJoin('orders', 'suppliers.id', '=', 'orders.supplier_id')
            ->select(
                'suppliers.id',
                'suppliers.name',
                DB::raw('COUNT(orders.id) as orders'),
                DB::raw('COALESCE(SUM(CASE WHEN orders.status = "Delivered" THEN orders.total_amount ELSE 0 END), 0) as revenue')
            )
            ->groupBy('suppliers.id', 'suppliers.name')
            ->orderBy('revenue', 'desc')
            ->paginate(10); 

        return view('analytics.supplier-performance', compact(
            'supplier_performance',
            'total_revenue',
            'supplier_count',
            'total_orders'
        ));
    }
}