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
    public function index()
    {
        $this->authorizeAdmin();

        try {
            // This works because of your Supplier model's orders() relationship
            $suppliers = Supplier::withCount('orders')->latest()->get();
        } catch (\Exception $e) {
            $suppliers = Supplier::latest()->get();
        }

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

        try {
            DB::beginTransaction();

            // 1. Create the Business Entity
            $supplier = Supplier::create([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // 2. Create the User and link them to the Supplier
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'supplier',
                'supplier_id' => $supplier->id, // This is the column we just added
            ]);

            DB::commit();
            return redirect()->route('admin.suppliers.index')->with('success', 'Supplier Node Deployed.');

        } catch (\Exception $e) {
            DB::rollback();
            // If it still fails, this will tell you why
            dd("Error on Line " . $e->getLine() . ": " . $e->getMessage());
        }
    }

    private function authorizeAdmin()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }
    }
}