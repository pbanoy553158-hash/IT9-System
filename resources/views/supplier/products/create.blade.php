<x-app-layout>
    <div class="min-h-[calc(100vh-64px)] flex flex-col justify-center py-8 px-4 antialiased selection:bg-indigo-500/30 font-['Inter']">
        
        <div class="max-w-2xl mx-auto w-full space-y-5">
            
            {{-- Back Link --}}
            <div class="px-1">
                <a href="{{ route('supplier.products.index') }}" 
                   class="text-xs font-semibold text-slate-500 hover:text-indigo-400 transition-colors flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to inventory
                </a>
            </div>

            {{-- Glass Form Card --}}
            <div class="relative">
                <div class="absolute -inset-2 bg-indigo-500/5 rounded-[2.5rem] blur-3xl"></div>
                
                <div class="relative bg-[#11101d]/80 border border-white/10 rounded-3xl shadow-2xl backdrop-blur-xl overflow-hidden">
                    <div class="p-8">
                        {{-- Header --}}
                        <div class="mb-8">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="px-2 py-0.5 rounded-md bg-indigo-500/10 border border-indigo-500/20 text-[10px] font-bold text-indigo-400">Inventory Node</span>
                            </div>
                            <h2 class="text-xl font-bold text-white tracking-tight">Register New Supply</h2>
                            <p class="text-[11px] text-slate-400 mt-1 font-medium">Categorize and deploy your assets to the hub.</p>
                        </div>

                        <form method="POST" action="{{ route('supplier.products.store') }}" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                
                                {{-- Image Upload Section --}}
                                <div class="space-y-2">
                                    <label class="block text-xs font-semibold text-slate-400 ml-1">Asset Image</label>
                                    <div id="image-preview-container" class="group relative h-[280px] flex flex-col justify-center items-center bg-white/[0.02] border border-white/5 border-dashed rounded-2xl hover:border-indigo-500/40 transition-all cursor-pointer overflow-hidden">
                                        <div id="upload-placeholder" class="flex flex-col items-center">
                                            <svg class="h-8 w-8 text-slate-600 group-hover:text-indigo-400 mb-2 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <span class="text-xs font-bold text-indigo-400 group-hover:text-indigo-300">Upload Photo</span>
                                        </div>
                                        <input id="product_image" name="product_image" type="file" class="sr-only" accept="image/*" onchange="previewImage(this)">
                                    </div>
                                </div>

                                {{-- Details Section --}}
                                <div class="space-y-4">
                                    {{-- Name --}}
                                    <div class="space-y-1.5">
                                        <label class="block text-xs font-semibold text-slate-400 ml-1">Asset Name</label>
                                        <input type="text" name="name" required placeholder="e.g. Copper Wire, Canned Goods..."
                                               class="w-full rounded-xl bg-white/[0.03] border border-white/5 text-[13px] text-white px-4 py-2.5 focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/5 outline-none transition-all">
                                    </div>

                                    {{-- Category Select --}}
                                    <div class="space-y-1.5">
                                        <label class="block text-xs font-semibold text-slate-400 ml-1">Supply Category</label>
                                        <div class="relative group">
                                            <select name="category_id" required class="w-full rounded-xl bg-white/[0.03] border border-white/5 text-[13px] text-white px-4 py-2.5 focus:border-indigo-500/50 outline-none appearance-none cursor-pointer">
                                                <option value="" disabled selected class="bg-[#11101d]">Select Sector</option>
                                                {{-- Ensure these are added to your categories table --}}
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" class="bg-[#11101d]">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-500">
                                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M19 9l-7 7-7-7" /></svg>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Pricing & Stock --}}
                                    <div class="grid grid-cols-2 gap-3">
                                        <div class="space-y-1.5">
                                            <label class="block text-xs font-semibold text-slate-400 ml-1">Price (₱)</label>
                                            <input type="number" step="0.01" name="price" required placeholder="0.00"
                                                   class="w-full rounded-xl bg-white/[0.03] border border-white/5 text-[13px] text-white px-4 py-2.5 focus:border-indigo-500/50 outline-none">
                                        </div>
                                        <div class="space-y-1.5">
                                            <label class="block text-xs font-semibold text-slate-400 ml-1">Unit</label>
                                            <select name="unit" class="w-full rounded-xl bg-white/[0.03] border border-white/5 text-[13px] text-white px-4 py-2.5 focus:border-indigo-500/50 outline-none appearance-none cursor-pointer">
                                                <option value="pcs" class="bg-[#11101d]">Pcs</option>
                                                <option value="kg" class="bg-[#11101d]">Kg</option>
                                                <option value="mtr" class="bg-[#11101d]">Meters</option>
                                                <option value="box" class="bg-[#11101d]">Box</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="space-y-1.5">
                                        <label class="block text-xs font-semibold text-slate-400 ml-1">Initial Stock Level</label>
                                        <input type="number" name="stock" required placeholder="0"
                                               class="w-full rounded-xl bg-white/[0.03] border border-white/5 text-[13px] text-white px-4 py-2.5 focus:border-indigo-500/50 outline-none font-medium">
                                    </div>
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="mt-8 pt-6 flex items-center justify-between border-t border-white/5">
                                <button type="reset" class="text-xs font-semibold text-slate-500 hover:text-white transition-colors">Clear Fields</button>
                                <button type="submit" 
                                        class="px-8 py-3 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl font-bold text-xs transition-all shadow-lg shadow-indigo-600/20 active:scale-95 border border-white/10">
                                    Deploy Asset
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Script for Image Preview --}}
    <script>
        function previewImage(input) {
            const container = document.getElementById('image-preview-container');
            const placeholder = document.getElementById('upload-placeholder');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const existingImg = container.querySelector('img');
                    if (existingImg) existingImg.remove();
                    placeholder.classList.add('hidden');
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'absolute inset-0 w-full h-full object-cover rounded-2xl animate-in fade-in zoom-in-95 duration-300';
                    container.appendChild(img);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        document.getElementById('image-preview-container').onclick = () => document.getElementById('product_image').click();
    </script>
</x-app-layout>