<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller 
{
    /**
     * Display the inventory list with search and low stock logic.
     */
    public function index(Request $request) 
    {
        // Get the supplier ID (Fallback to 1 for testing if user is not linked)
        $supplierId = Auth::user()->supplier_id ?? 1;

        $query = Product::where('supplier_id', $supplierId);

        // Filter by name or SKU if searching
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
            });
        }

        // Load categories to display names in the table
        $products = $query->with('category')->latest()->paginate(10);
        
        return view('supplier.products.index', compact('products'));
    }

    /**
     * Show the form to register a new asset.
     */
    public function create() 
    {
        $categories = Category::all();
        return view('supplier.products.create', compact('categories'));
    }

    /**
     * Store the asset and handle image processing.
     */
    public function store(Request $request) 
    {
        // 1. Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'unit' => 'required|string',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', 
        ]);

        // 2. Handle Image Upload to 'public/products'
        $imagePath = null;
        if ($request->hasFile('product_image')) {
            $imagePath = $request->file('product_image')->store('products', 'public');
        }

        // 3. Set the Supplier ID (Prevents the 'null' vanish error)
        $supplierId = Auth::user()->supplier_id ?? 1;

        // 4. Create the Record
        Product::create([
            'supplier_id' => $supplierId,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'sku' => 'PRD-' . strtoupper(bin2hex(random_bytes(3))), // e.g., PRD-F3A2B1
            'price' => $request->price,
            'stock' => $request->stock,
            'unit' => $request->unit,
            'status' => 'Pending',
            'image_path' => $imagePath,
        ]);

        return redirect()->route('supplier.products.index')
            ->with('success', 'Asset successfully deployed to catalog.');
    }

    /**
     * Show edit form.
     */
    public function edit(Product $product) 
    {
        // Check ownership
        $supplierId = Auth::user()->supplier_id ?? 1;
        if ($product->supplier_id != $supplierId) {
            abort(403, 'Unauthorized.');
        }

        $categories = Category::all();
        return view('supplier.products.edit', compact('product', 'categories'));
    }

    /**
     * Update existing asset.
     */
    public function update(Request $request, Product $product) 
    {
        // 1. Check ownership (Safety first!)
        $supplierId = Auth::user()->supplier_id ?? 1;
        if ($product->supplier_id != $supplierId) {
            abort(403, 'Unauthorized.');
        }

        // 2. Validation
        // Note: Ensure category_id is actually sent by your form
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'unit' => 'required|string',
            'status' => 'required|string', // Added because it's in your form
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // 3. Handle Image replacement
        if ($request->hasFile('product_image')) {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $validated['image_path'] = $request->file('product_image')->store('products', 'public');
        }

        // 4. Update the record
        $product->update($validated);

        return redirect()->route('supplier.products.index')
            ->with('success', 'Asset updated.');
    }
    /**
     * Delete asset.
     */
    public function destroy(Product $product) 
    {
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()->route('supplier.products.index')
            ->with('success', 'Asset removed.');
    }
}