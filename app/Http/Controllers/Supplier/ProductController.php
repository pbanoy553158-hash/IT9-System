<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller 
{
    /**
     * Display a listing of the products.
     */
    public function index(Request $request) 
    {
        $query = Product::where('user_id', Auth::id());

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
            });
        }

        $products = $query->latest()->paginate(10);
        return view('supplier.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create() 
    {
        return view('supplier.products.create');
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request) 
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'unit' => 'required|string',
            'status' => 'required|string',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', 
        ]);

        $imagePath = null;
        if ($request->hasFile('product_image')) {
            $imagePath = $request->file('product_image')->store('products', 'public');
        }

        Product::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'sku' => 'PRD-' . strtoupper(bin2hex(random_bytes(3))),
            'price' => $request->price,
            'stock' => $request->stock,
            'unit' => $request->unit,
            'status' => $request->status,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('supplier.products.index')
            ->with('success', 'Product registered successfully.');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product) 
    {
        if ($product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('supplier.products.edit', compact('product'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product) 
    {
        if ($product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'unit' => 'required|string',
            'status' => 'required|string',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('product_image')) {
            // Delete old image if it exists
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            // Store new image and update the path
            $validated['image_path'] = $request->file('product_image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('supplier.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product) 
    {
        if ($product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()->route('supplier.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}