<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | REPORTS OVERVIEW
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $total_revenue = Order::where('status', 'Delivered')->sum('total_amount');
        $supplier_count = Supplier::count();
        $total_orders = Order::count();

        return view('admin.reports.index', compact(
            'total_revenue',
            'supplier_count',
            'total_orders'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | SUPPLIER PERFORMANCE ANALYTICS
    |--------------------------------------------------------------------------
    */
    public function supplierPerformance()
    {
        $total_revenue = Order::where('status', 'Delivered')->sum('total_amount');
        $supplier_count = Supplier::count();
        $total_orders = Order::count();

        $supplier_performance = Supplier::leftJoin('orders', 'suppliers.id', '=', 'orders.supplier_id')
            ->select(
                'suppliers.name',
                DB::raw('COUNT(orders.id) as orders'),
                DB::raw('COALESCE(SUM(CASE WHEN orders.status = "Delivered" THEN orders.total_amount ELSE 0 END), 0) as revenue')
            )
            ->groupBy('suppliers.id', 'suppliers.name')
            ->get();

        return view('analytics.supplier-performance', compact(
            'supplier_performance',
            'total_revenue',
            'supplier_count',
            'total_orders'
        ));
    }
}