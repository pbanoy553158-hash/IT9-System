<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Activity; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('supplier_id', Auth::user()->supplier_id)
            ->with('category');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('sku', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $products = $query->latest()->get();
        $categories = Category::orderBy('name')->get();

        return view('supplier.products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        if ($product->supplier_id !== Auth::user()->supplier_id) {
            abort(403);
        }

        $product->load('category');
        return view('supplier.products.show', compact('product'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('supplier.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'unit' => 'required|string',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,avif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('product_image')) {
            $imagePath = $request->file('product_image')->store('products', 'public');
        }

        $sku = strtoupper(Str::slug($request->name)) . '-' . strtoupper(Str::random(5));

        $product = Product::create([
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

        Activity::create([
            'user_id'     => Auth::id(),
            'type'        => 'product',
            'title'       => 'Product Added',
            'description' => "Product {$product->name} was added to inventory.",
            'status'      => 'Active',
        ]);

        return redirect()->route('supplier.products.index')
            ->with('success', 'Asset successfully deployed to inventory.');
    }

    public function edit(Product $product)
    {
        if ($product->supplier_id !== Auth::user()->supplier_id) {
            abort(403);
        }

        $categories = Category::orderBy('name')->get();
        return view('supplier.products.edit', compact('product', 'categories'));
    }

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

        // 1. Get all data except the image file
        $updateData = $request->except('product_image');

        // 2. Handle image upload if a new file is provided
        if ($request->hasFile('product_image')) {
            // Delete old image
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }

            // Store new image and add it to the update array
            $updateData['image_path'] = $request->file('product_image')->store('products', 'public');
        }

        // 3. Update everything at once
        $product->update($updateData);

        Activity::create([
            'user_id'     => Auth::id(),
            'type'        => 'product',
            'title'       => 'Product Updated',
            'description' => "Product {$product->name} was updated.",
            'status'      => $request->status,
        ]);

        return redirect()->route('supplier.products.index')
            ->with('success', 'Product information updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->supplier_id !== Auth::user()->supplier_id) {
            abort(403);
        }

        $name = $product->name;

        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        Activity::create([
            'user_id'     => Auth::id(),
            'type'        => 'product',
            'title'       => 'Product Removed',
            'description' => "Product {$name} was removed from inventory.",
            'status'      => 'Deleted',
        ]);

        return redirect()->route('supplier.products.index')
            ->with('success', 'Asset decommissioned and removed from system.');
    }
}