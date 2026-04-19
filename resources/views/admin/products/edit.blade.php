@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-3xl">
    <div class="mb-6">
        <a href="{{ route('supplier.products.index') }}" class="text-blue-600 hover:underline">← Cancel</a>
        <h1 class="text-2xl font-bold mt-2">Edit Product: {{ $product->name }}</h1>
    </div>

    <form action="{{ route('supplier.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded-lg p-8">
        @csrf
        @method('PATCH')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="col-span-2 text-center mb-4">
                @if($product->image_path)
                    <p class="text-xs text-gray-500 mb-2">Current Image:</p>
                    <img src="{{ asset('storage/' . $product->image_path) }}" class="mx-auto w-32 h-32 object-cover rounded-md border">
                @endif
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Product Name</label>
                <input type="text" name="name" value="{{ $product->name }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
                <select name="category_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Unit</label>
                <input type="text" name="unit" value="{{ $product->unit }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Price (₱)</label>
                <input type="number" name="price" step="0.01" value="{{ $product->price }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Update Stock</label>
                <input type="number" name="stock" value="{{ $product->stock }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Replace Product Image (Optional)</label>
                <input type="file" name="product_image" class="w-full text-sm text-gray-500">
            </div>
        </div>

        <div class="mt-8 flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition">
                Update Product
            </button>
        </div>
    </form>
</div>
@endsection