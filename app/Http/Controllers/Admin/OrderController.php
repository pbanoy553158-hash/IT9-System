<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;

class SupplierController extends Controller
{
    /**
     * Display a listing of the suppliers with pagination.
     */
    public function index()
    {
        $this->authorizeAdmin();

        $suppliers = Supplier::query()
            ->select('suppliers.*')
            /** 
             * Subquery to count only delivered orders. 
             * This avoids loading all orders into memory.
             */
            ->selectSub(function ($query) {
                $query->from('orders')
                    ->selectRaw('COUNT(*)')
                    ->whereColumn('orders.supplier_id', 'suppliers.id')
                    ->whereRaw('LOWER(TRIM(status)) = ?', ['delivered']);
            }, 'orders_count')
            ->latest()
            ->paginate(6); // Updated to 6 items per page

        return view('admin.suppliers.index', compact('suppliers'));
    }

    /**
     * Store a newly created supplier and associated user account.
     */
    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        DB::beginTransaction();

        try {
            // 1. Create the Supplier profile
            $supplier = Supplier::create([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // 2. Create the User account linked to the supplier
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'supplier',
                'supplier_id' => $supplier->id,
            ]);

            DB::commit();

            return redirect()
                ->route('admin.suppliers.index')
                ->with('success', 'Supplier created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withErrors(['error' => 'Failed to create supplier. Internal error: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Remove the specified supplier and their associated user account.
     */
    public function destroy(Supplier $supplier)
    {
        $this->authorizeAdmin();

        DB::beginTransaction();

        try {
            /**
             * We remove the associated user record first to maintain 
             * referential integrity before deleting the supplier.
             */
            User::where('supplier_id', $supplier->id)->delete();
            $supplier->delete();

            DB::commit();

            return redirect()
                ->route('admin.suppliers.index')
                ->with('success', 'Supplier and associated user account deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors([
                'error' => 'Unable to delete supplier. Check for active order dependencies.'
            ]);
        }
    }

    /**
     * Simple role-based authorization check.
     */
    private function authorizeAdmin()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }
    }
}