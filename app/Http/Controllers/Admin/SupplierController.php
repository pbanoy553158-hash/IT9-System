<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class SupplierController extends Controller
{
    /**
     * Display supplier registry
     */
    public function index()
    {
        $this->authorizeAdmin();

        $suppliers = User::where('role', 'supplier')
            ->withCount('orders')
            ->latest()
            ->get();

        return view('admin.suppliers.index', compact('suppliers'));
    }

    /**
     * Store new supplier
     */
    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'supplier',
        ]);

        return redirect()
            ->route('admin.suppliers.index')
            ->with('success', 'Supplier successfully registered.');
    }

    /**
     * Remove supplier
     */
    public function destroy(User $supplier)
    {
        $this->authorizeAdmin();

        if ($supplier->role !== 'supplier') {
            return back()->with('error', 'Invalid operation.');
        }

        $supplier->delete();

        return redirect()
            ->route('admin.suppliers.index')
            ->with('success', 'Supplier removed successfully.');
    }

    /**
     * CENTRALIZED ADMIN CHECK (cleaner)
     */
    private function authorizeAdmin()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Admin access required.');
        }
    }
}