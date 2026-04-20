<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <span class="text-slate-500 font-medium text-xs tracking-tight">Directory /</span>
            <span class="text-white font-bold tracking-tight text-xs">Product registration</span>
        </div>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        
        .font-inter { font-family: 'Inter', sans-serif !important; }

        .custom-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%235046e5'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 0.9em;
        }

        .glass-card {
            background: linear-gradient(145deg, #0f111a 0%, #050608 100%);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .input-field {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.2s ease;
        }

        .input-field:focus {
            border-color: #5046e5;
            background: rgba(80, 70, 229, 0.02);
            box-shadow: 0 0 0 1px rgba(80, 70, 229, 0.2);
        }
    </style>

    <div class="min-h-[80vh] py-10 px-4 font-inter antialiased flex items-center justify-center">
        <div class="max-w-2xl w-full">
            
            <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="glass-card rounded-[24px] overflow-hidden shadow-2xl flex flex-col md:flex-row min-h-[400px]">
                    
                    {{-- Media Section --}}
                    <div class="w-full md:w-5/12 p-6 flex flex-col items-center justify-center border-r border-white/5 bg-black/20 shrink-0">
                        <div class="w-full aspect-square max-h-[180px] rounded-2xl border-2 border-dashed border-white/5 bg-white/[0.01] flex flex-col items-center justify-center text-center p-4 group relative cursor-pointer hover:border-[#5046e5]/30 transition-all">
                            <input type="file" name="image" class="absolute inset-0 opacity-0 cursor-pointer z-10" id="imageInput">
                            
                            <div class="w-10 h-10 mb-3 rounded-xl bg-[#5046e5]/10 flex items-center justify-center text-[#5046e5] group-hover:scale-110 transition-transform duration-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>

                            <h4 class="text-white font-semibold text-xs">Product image</h4>
                            <p class="text-slate-500 text-[10px] mt-1 leading-relaxed">Select or drag & drop</p>
                        </div>
                    </div>

                    {{-- Form Fields Section --}}
                    <div class="w-full md:w-7/12 p-8 flex flex-col justify-center">
                        <div class="mb-6">
                            <h3 class="text-xl font-bold text-white tracking-tight">Product <span class="text-[#5046e5]">entry</span></h3>
                        </div>

                        <div class="space-y-3.5">
                            <div class="space-y-1">
                                <label class="text-[11px] font-semibold text-slate-400 ml-1">Designation</label>
                                <input type="text" name="name" placeholder="Enter product name..." required 
                                    class="input-field w-full rounded-xl px-4 py-2 text-xs text-white focus:outline-none transition-all placeholder:opacity-20">
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div class="space-y-1">
                                    <label class="text-[11px] font-semibold text-slate-400 ml-1">SKU identifier</label>
                                    <input type="text" name="sku" placeholder="TRK-0000" required 
                                        class="input-field w-full rounded-xl px-4 py-2 text-xs font-mono text-[#5046e5] focus:outline-none">
                                </div>
                                <div class="space-y-1">
                                    <label class="text-[11px] font-semibold text-slate-400 ml-1">Classification</label>
                                    <select name="category_id" required class="custom-select input-field w-full rounded-xl px-4 py-2 text-xs text-slate-400 focus:outline-none cursor-pointer">
                                        <option value="" disabled selected>Select category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" class="bg-[#0f111a] text-white">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div class="space-y-1">
                                    <label class="text-[11px] font-semibold text-slate-400 ml-1">Valuation (₱)</label>
                                    <input type="number" step="0.01" name="price" placeholder="0.00" required
                                        class="input-field w-full rounded-xl px-4 py-2 text-xs text-white focus:outline-none">
                                </div>
                                <div class="space-y-1">
                                    <label class="text-[11px] font-semibold text-slate-400 ml-1">Origin source</label>
                                    <select name="supplier_id" required class="custom-select input-field w-full rounded-xl px-4 py-2 text-xs text-slate-400 focus:outline-none cursor-pointer">
                                        <option value="" disabled selected>Choose supplier</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" class="bg-[#0f111a] text-white">{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="space-y-1">
                                <label class="text-[11px] font-semibold text-slate-400 ml-1">Initial stock level</label>
                                <input type="number" name="stock" placeholder="0" 
                                    class="input-field w-full rounded-xl px-4 py-2 text-xs text-white focus:outline-none">
                            </div>
                        </div>

                        <div class="pt-6 flex items-center justify-end gap-5">
                            <a href="{{ route('admin.products.index') }}" class="text-[11px] font-semibold text-slate-500 hover:text-white transition-colors">
                                Cancel
                            </a>
                            <button type="submit" 
                                class="px-6 py-2.5 bg-[#5046e5] hover:bg-[#4338ca] text-white rounded-xl font-bold text-xs transition-all shadow-lg shadow-[#5046e5]/20 active:scale-95">
                                Deploy asset
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>