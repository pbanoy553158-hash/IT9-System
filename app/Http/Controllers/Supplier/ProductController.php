<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * 1. INDEX: Displays the inventory list with Search and Filter
     */
    public function index(Request $request)
    {
        $query = Product::where('supplier_id', Auth::user()->supplier_id)
            ->with('category');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('sku', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $products = $query->latest()->get();
        $categories = Category::orderBy('name', 'asc')->get();

        return view('supplier.products.index', compact('products', 'categories'));
    }

    /**
     * 2. CREATE: Shows the registration form
     */
    public function create()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        return view('supplier.products.create', compact('categories'));
    }

    /**
     * 3. STORE: Saves new products with auto-generated SKU
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'unit' => 'required|string',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('product_image')) {
            $imagePath = $request->file('product_image')->store('products', 'public');
        }

        $sku = strtoupper(Str::slug($request->name)) . '-' . strtoupper(Str::random(5));

        Product::create([
            'supplier_id' => Auth::user()->supplier_id,
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'sku'         => $sku,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'unit'        => $request->unit,
            'status'      => 'Active',
            'image_path'  => $imagePath,
        ]);

        return redirect()->route('supplier.products.index')->with('success', 'Asset successfully deployed to inventory.');
    }

    /**
     * 4. EDIT: Shows the update form
     */
    public function edit(Product $product)
    {
        if ($product->supplier_id !== Auth::user()->supplier_id) {
            abort(403);
        }

        $categories = Category::orderBy('name', 'asc')->get();
        return view('supplier.products.edit', compact('product', 'categories'));
    }

    /**
     * 5. UPDATE: Saves changes to existing products
     */
    public function update(Request $request, Product $product)
    {
        if ($product->supplier_id !== Auth::user()->supplier_id) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'unit' => 'required|string',
            'status' => 'required|in:Active,Inactive',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('product_image')) {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $product->image_path = $request->file('product_image')->store('products', 'public');
        }

        $product->update($request->except('product_image'));

        return redirect()->route('supplier.products.index')->with('success', 'Product information updated successfully.');
    }

    /**
     * 6. DESTROY: Deletes the product and cleans up files
     */
    public function destroy(Product $product)
    {
        // Security check
        if ($product->supplier_id !== Auth::user()->supplier_id) {
            abort(403);
        }

        // Delete image file from storage if it exists
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()->route('supplier.products.index')
            ->with('success', 'Asset decommissioned and removed from system.');
    }
}