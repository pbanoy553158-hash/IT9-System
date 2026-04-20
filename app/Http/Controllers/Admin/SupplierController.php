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
     * Display supplier directory with delivered orders count
     */
    public function index()
    {
        $this->authorizeAdmin();

        $suppliers = Supplier::query()
            ->select('suppliers.*')
            ->selectSub(function ($query) {
                $query->from('orders')
                    ->selectRaw('COUNT(*)')
                    ->whereColumn('orders.supplier_id', 'suppliers.id')
                    ->whereRaw('LOWER(TRIM(status)) = ?', ['delivered']);
            }, 'orders_count')
            ->latest()
            ->get();

        return view('admin.suppliers.index', compact('suppliers'));
    }

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
            $supplier = Supplier::create([
                'name' => $request->name,
                'email' => $request->email,
            ]);

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
                ->with('success', 'Supplier account created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withErrors(['error' => 'Failed to create supplier account.'])
                ->withInput();
        }
    }

    public function edit(Supplier $supplier)
    {
        $this->authorizeAdmin();
        return view('admin.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $this->authorizeAdmin();

        $user = User::where('supplier_id', $supplier->id)->first();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . ($user?->id ?? 'NULL'),
            ],
        ]);

        DB::beginTransaction();

        try {
            $supplier->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            if ($user) {
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                ]);

                if ($request->filled('password')) {
                    $request->validate([
                        'password' => ['confirmed', Rules\Password::defaults()]
                    ]);

                    $user->update([
                        'password' => Hash::make($request->password)
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('admin.suppliers.index')
                ->with('success', 'Supplier updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withErrors(['error' => 'Update failed.'])
                ->withInput();
        }
    }

    public function destroy(Supplier $supplier)
    {
        $this->authorizeAdmin();

        DB::beginTransaction();

        try {
            User::where('supplier_id', $supplier->id)->delete();
            $supplier->delete();

            DB::commit();

            return redirect()
                ->route('admin.suppliers.index')
                ->with('success', 'Supplier removed successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors([
                'error' => 'Unable to delete supplier.'
            ]);
        }
    }

    private function authorizeAdmin()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }
    }
}