<x-app-layout>
    <div class="min-h-screen bg-[#050508] flex flex-col justify-center py-8 px-6 antialiased font-['Inter']">
        <div class="max-w-lg mx-auto w-full">
            
            <div class="mb-6">
                <a href="{{ route('supplier.products.index') }}" 
                   class="inline-flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-slate-500 hover:text-white transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to inventory
                </a>
            </div>

            <div class="bg-[#0d0d12] border border-white/[0.05] rounded-[1.5rem] shadow-2xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-48 h-48 bg-indigo-500/5 blur-[80px] pointer-events-none"></div>

                <div class="p-8 relative z-10">
                    <header class="mb-8">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="px-2 py-0.5 rounded-md bg-amber-500/10 border border-amber-500/20 text-[9px] font-bold text-amber-400 uppercase tracking-tighter">Modify Node</span>
                        </div>
                        <h2 class="text-2xl font-semibold text-white tracking-tight">Edit product</h2>
                        <p class="text-slate-500 text-xs mt-1">Updating SKU: <span class="text-indigo-400 font-mono">{{ $product->sku }}</span></p>
                    </header>

                    <form method="POST" action="{{ route('supplier.products.update', $product->id) }}" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        @method('PATCH')

                        <div class="space-y-2">
                            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider">Product image</label>
                            <div class="flex items-center gap-4 p-3 bg-white/[0.02] border border-white/5 rounded-xl">
                                @if($product->image_path)
                                    <img src="{{ asset('storage/' . $product->image_path) }}" 
                                         class="w-14 h-14 object-cover rounded-lg border border-white/10 shadow-lg">
                                @endif
                                <div class="flex-1">
                                    <input type="file" name="product_image" 
                                           class="block w-full text-[10px] text-slate-500 
                                           file:mr-3 file:py-1.5 file:px-3 
                                           file:rounded-md file:border-0 
                                           file:text-[9px] file:font-bold file:uppercase 
                                           file:bg-indigo-500/10 file:text-indigo-400 
                                           hover:file:bg-indigo-500/20 transition-all cursor-pointer">
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider">Product name</label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                                   class="w-full rounded-lg bg-white/[0.02] border border-white/10 text-white px-4 py-2.5 text-sm focus:border-indigo-500/50 focus:ring-0 outline-none transition-all">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider">Price (₱)</label>
                                <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" required
                                       class="w-full rounded-lg bg-white/[0.02] border border-white/10 text-white px-4 py-2.5 text-sm focus:border-indigo-500/50 outline-none">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider">Stock</label>
                                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required
                                       class="w-full rounded-lg bg-white/[0.02] border border-white/10 text-white px-4 py-2.5 text-sm focus:border-indigo-500/50 outline-none">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider">Unit</label>
                                <select name="unit" class="w-full rounded-lg bg-[#0d0d12] border border-white/10 text-white px-4 py-2.5 text-sm focus:border-indigo-500/50 outline-none">
                                    <option value="pcs" {{ $product->unit == 'pcs' ? 'selected' : '' }}>pcs</option>
                                    <option value="kg" {{ $product->unit == 'kg' ? 'selected' : '' }}>kg</option>
                                    <option value="box" {{ $product->unit == 'box' ? 'selected' : '' }}>box</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status</label>
                                <select name="status" class="w-full rounded-lg bg-[#0d0d12] border border-white/10 text-white px-4 py-2.5 text-sm focus:border-indigo-500/50 outline-none">
                                    <option value="Active" {{ $product->status == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Inactive" {{ $product->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="pt-6 flex items-center justify-between border-t border-white/5">
                            <a href="{{ route('supplier.products.index') }}" class="text-[11px] font-bold text-slate-500 hover:text-white uppercase tracking-tighter transition-colors">Cancel</a>
                            <button type="submit" 
                                    class="px-8 py-3 bg-white text-black hover:bg-amber-500 hover:text-white rounded-xl font-bold text-[10px] uppercase tracking-widest shadow-lg active:scale-95 transition-all">
                                Update Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>