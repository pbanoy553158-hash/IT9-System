<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * View all products from all suppliers.
     * Includes filters for the status tabs (Pending, Active, etc.)
     */
    public function index(Request $request)
    {
        $query = Product::with(['user', 'category']); // 'user' represents the supplier here

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $products = $query->latest()->paginate(15);
        
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show a specific product's details and supplier history.
     */
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Approve a supplier's product to make it visible in the system.
     */
    public function approve(Product $product)
    {
        $product->update(['status' => 'active']);
        
        return back()->with('success', "{$product->name} is now active.");
    }

    /**
     * Reject or Deactivate a product.
     */
    public function reject(Product $product)
    {
        $product->update(['status' => 'rejected']);
        
        return back()->with('error', "{$product->name} has been rejected.");
    }

    /**
     * Remove a product from the system (Soft Delete).
     */
    public function destroy(Product $product)
    {
        $product->delete();
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Product removed from catalog.');
    }
}