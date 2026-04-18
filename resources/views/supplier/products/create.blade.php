<x-app-layout>
    <div class="min-h-screen bg-[#11111d] flex flex-col justify-center py-8 px-6 antialiased font-['Inter']">
        <div class="max-w-3xl mx-auto w-full">
            
            <div class="mb-6">
                <a href="{{ route('supplier.products.index') }}" 
                   class="inline-flex items-center gap-2 text-[11px] font-medium text-slate-400 hover:text-indigo-400 transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back To Inventory
                </a>
            </div>

            <div class="bg-[#1c1c2d] border border-white/[0.03] rounded-[1.5rem] shadow-2xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-48 h-48 bg-indigo-500/5 blur-[80px] pointer-events-none"></div>

                <div class="p-8 relative z-10">
                    <header class="mb-8">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="px-2 py-0.5 rounded-md bg-indigo-500/10 border border-indigo-500/20 text-[10px] font-medium text-indigo-400">Node Entry</span>
                        </div>
                        <h2 class="text-2xl font-semibold text-white tracking-tight">Register Supply</h2>
                        <p class="text-slate-400 text-xs mt-1">Log Transmission Details To The Hub.</p>
                    </header>

                    <form method="POST" action="{{ route('supplier.products.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            
                            <div class="space-y-3">
                                <label class="block text-xs font-medium text-slate-400">Product Display Image</label>
                                <div class="group relative h-full min-h-[200px] flex flex-col justify-center items-center bg-[#151521] border-2 border-white/[0.05] border-dashed rounded-2xl hover:border-indigo-500/40 transition-all cursor-pointer">
                                    <svg class="h-8 w-8 text-slate-500 group-hover:text-indigo-400 mb-3 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <label for="product_image" class="text-xs font-medium text-indigo-400 hover:text-indigo-300 cursor-pointer">
                                        <span>Upload Image</span>
                                        <input id="product_image" name="product_image" type="file" class="sr-only" accept="image/*">
                                    </label>
                                    <p class="text-[10px] text-slate-600 mt-1">Jpeg, Png, Or Webp</p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-medium text-slate-400">Product Name</label>
                                    <input type="text" name="name" required placeholder="Item Name..."
                                           class="w-full rounded-lg bg-[#151521] border border-white/[0.05] text-white px-4 py-2 text-sm focus:ring-1 focus:ring-indigo-500/50 outline-none transition-all placeholder:text-slate-700">
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-1.5">
                                        <label class="block text-xs font-medium text-slate-400">Price (₱)</label>
                                        <input type="number" step="0.01" name="price" required placeholder="0.00"
                                               class="w-full rounded-lg bg-[#151521] border border-white/[0.05] text-white px-4 py-2 text-sm focus:ring-1 focus:ring-indigo-500/50 outline-none">
                                    </div>
                                    <div class="space-y-1.5">
                                        <label class="block text-xs font-medium text-slate-400">Initial Stock</label>
                                        <input type="number" name="stock" required placeholder="0"
                                               class="w-full rounded-lg bg-[#151521] border border-white/[0.05] text-white px-4 py-2 text-sm focus:ring-1 focus:ring-indigo-500/50 outline-none">
                                    </div>
                                </div>

                                <div class="space-y-1.5">
                                    <label class="block text-xs font-medium text-slate-400">Measurement Unit</label>
                                    <select name="unit" class="w-full rounded-lg bg-[#151521] border border-white/[0.05] text-white px-4 py-2 text-sm focus:ring-1 focus:ring-indigo-500/50 outline-none appearance-none cursor-pointer">
                                        <option value="pcs">Pieces (Pcs)</option>
                                        <option value="kg">Kilograms (Kg)</option>
                                        <option value="box">Box</option>
                                        <option value="mtr">Meters (Mtr)</option>
                                    </select>
                                </div>

                                <div class="space-y-1.5">
                                    <label class="block text-xs font-medium text-slate-400">Availability Status</label>
                                    <select name="status" class="w-full rounded-lg bg-[#151521] border border-white/[0.05] text-white px-4 py-2 text-sm focus:ring-1 focus:ring-indigo-500/50 outline-none appearance-none cursor-pointer">
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mt-10 pt-6 flex items-center justify-between border-t border-white/[0.05]">
                            <button type="reset" class="text-[11px] font-medium text-slate-500 hover:text-white transition-colors">Clear Fields</button>
                            <button type="submit" 
                                    class="px-8 py-3 bg-white text-[#11111d] hover:bg-indigo-400 hover:text-white rounded-xl font-bold text-[10px] uppercase tracking-widest shadow-lg active:scale-95 transition-all duration-300">
                                Deploy Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>