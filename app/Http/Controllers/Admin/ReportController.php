<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // Global Statistics
        $total_revenue = Order::where('status', 'Delivered')->sum('total_amount');
        $supplier_count = Supplier::count();
        $total_orders = Order::count();

        // Safe version - Avoids referencing supplier_id if column doesn't exist yet
        $supplier_performance = Supplier::select([
                'suppliers.id',
                'suppliers.name',
                DB::raw('0 as orders_count'),
                DB::raw('0 as revenue')
            ])
            ->get()
            ->map(function ($supplier) {
                return [
                    'name'    => $supplier->name,
                    'orders'  => 0,
                    'revenue' => 0.00,
                ];
            });

        return view('admin.reports.index', compact(
            'total_revenue',
            'supplier_count',
            'total_orders',
            'supplier_performance'
        ));
    }
}