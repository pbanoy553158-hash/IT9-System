<x-app-layout>
    <x-slot name="header">
        <span class="font-medium text-slate-400 tracking-widest text-xs">Directory /</span>
        <span class="font-bold text-white tracking-widest text-xs ml-1">Product registration</span>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        
        .font-inter { font-family: 'Inter', sans-serif !important; }

        .custom-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1em;
        }

        .glass-card {
            background: linear-gradient(145deg, rgba(15, 17, 26, 0.95) 0%, rgba(5, 6, 8, 1) 100%);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .upload-zone {
            background: radial-gradient(circle at center, rgba(80, 70, 229, 0.05) 0%, transparent 70%);
            border: 2px dashed rgba(80, 70, 229, 0.15);
            transition: all 0.3s ease;
        }

        .upload-zone:hover {
            border-color: rgba(80, 70, 229, 0.4);
            background: radial-gradient(circle at center, rgba(80, 70, 229, 0.1) 0%, transparent 70%);
        }
    </style>

    {{-- Container "Zoomed" by increasing vertical padding and max-width --}}
    <div class="min-h-[85vh] py-12 px-6 font-inter antialiased flex items-center justify-center">
        <div class="max-w-4xl w-full">
            
            <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                @csrf
                
                {{-- Increased rounded corners and internal padding for a better "fit" --}}
                <div class="glass-card rounded-[32px] overflow-hidden shadow-2xl flex flex-col md:flex-row min-h-[480px]">
                    
                    <div class="w-full md:w-5/12 p-8 flex flex-col items-center justify-center border-r border-white/5 bg-black/30 shrink-0">
                        <div class="w-full h-full rounded-[24px] upload-zone flex flex-col items-center justify-center p-6 text-center group cursor-pointer relative">
                            <input type="file" name="image" class="absolute inset-0 opacity-0 cursor-pointer z-10" id="imageInput">
                            
                            <div class="w-14 h-14 mb-4 rounded-2xl bg-[#5046e5]/10 flex items-center justify-center text-[#5046e5] group-hover:scale-110 transition-transform duration-500 shadow-[0_0_20px_rgba(80,70,229,0.1)]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>

                            <h4 class="text-white font-semibold text-base tracking-tight">Product image</h4>
                            <p class="text-slate-500 text-xs mt-2 max-w-[180px] leading-relaxed">
                                Select or drag & drop<br>
                                <span class="text-[10px] font-bold opacity-30">JPG, PNG, GIF</span>
                            </p>
                        </div>
                    </div>

                    <div class="w-full md:w-7/12 p-10 flex flex-col justify-center">
                        <div class="mb-8">
                            <h3 class="text-2xl font-bold text-white tracking-tight">Product <span class="text-[#5046e5]">entry</span></h3>
                        </div>

                        <div class="space-y-4">
                            {{-- Labels changed to Sentence case and slightly larger text (text-xs) --}}
                            <div class="space-y-1.5">
                                <label class="text-xs font-semibold text-slate-400 ml-1">Designation</label>
                                <input type="text" name="name" placeholder="Enter product name..." required 
                                    class="w-full bg-white/[0.03] border border-white/5 rounded-xl px-5 py-3 text-sm text-white focus:outline-none focus:border-[#5046e5]/50 transition-all placeholder:opacity-30">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-1.5">
                                    <label class="text-xs font-semibold text-slate-400 ml-1">SKU identifier</label>
                                    <input type="text" name="sku" placeholder="TRK-0000" required 
                                        class="w-full bg-white/[0.03] border border-white/5 rounded-xl px-5 py-3 text-sm font-mono text-[#5046e5] focus:outline-none focus:border-[#5046e5]/50 transition-all placeholder:opacity-30">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-xs font-semibold text-slate-400 ml-1">Classification</label>
                                    <select name="category_id" required class="custom-select w-full bg-white/[0.03] border border-white/5 rounded-xl px-5 py-3 text-sm text-slate-400 focus:outline-none focus:border-[#5046e5]/50 transition-all cursor-pointer">
                                        <option value="" disabled selected>Select category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" class="bg-[#0a0c12] text-white">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-1.5">
                                    <label class="text-xs font-semibold text-slate-400 ml-1">Valuation (₱)</label>
                                    <input type="number" step="0.01" name="price" placeholder="0.00" required
                                        class="w-full bg-white/[0.03] border border-white/5 rounded-xl px-5 py-3 text-sm text-white focus:outline-none focus:border-[#5046e5]/50 transition-all placeholder:opacity-30">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-xs font-semibold text-slate-400 ml-1">Origin source</label>
                                    <select name="supplier_id" required class="custom-select w-full bg-white/[0.03] border border-white/5 rounded-xl px-5 py-3 text-sm text-slate-400 focus:outline-none focus:border-[#5046e5]/50 transition-all cursor-pointer">
                                        <option value="" disabled selected>Choose supplier</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" class="bg-[#0a0c12] text-white">{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-xs font-semibold text-slate-400 ml-1">Initial stock level</label>
                                <input type="number" name="stock" placeholder="0" 
                                    class="w-full bg-white/[0.03] border border-white/5 rounded-xl px-5 py-3 text-sm text-white focus:outline-none focus:border-[#5046e5]/50 transition-all placeholder:opacity-30">
                            </div>
                        </div>

                        <div class="pt-8 flex items-center justify-end gap-6">
                            <a href="{{ route('admin.products.index') }}" class="text-xs font-semibold text-slate-500 hover:text-white transition-colors">
                                Cancel
                            </a>
                            <button type="submit" 
                                class="inline-flex items-center gap-2 px-8 py-3.5 bg-[#5046e5] hover:bg-[#4338ca] text-white rounded-[16px] font-semibold text-sm transition-all shadow-[0_4px_20px_0_rgba(80,70,229,0.4)] active:scale-95">
                                <span class="font-normal opacity-70"></span> Deploy asset
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>