<x-app-layout>
    {{-- Main Container --}}
    <div class="min-h-[calc(100vh-64px)] flex flex-col justify-center py-8 px-4 antialiased selection:bg-indigo-500/30">
        
        {{-- Narrower width for a "nicer" aesthetic (max-w-sm) --}}
        <div class="max-w-sm mx-auto w-full space-y-5">
            
            {{-- Back Link --}}
            <div class="px-1">
                <a href="{{ route('supplier.orders.index') }}"
                   class="text-xs font-semibold text-slate-500 hover:text-indigo-400 transition-colors flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to order log
                </a>
            </div>

            {{-- Glass Form Card --}}
            <div class="relative">
                {{-- Soft Ambient Glow --}}
                <div class="absolute -inset-2 bg-indigo-500/5 rounded-[2rem] blur-2xl"></div>
                
                <div class="relative bg-[#11101d]/80 border border-white/10 rounded-3xl shadow-2xl backdrop-blur-xl overflow-hidden">
                    <div class="p-7">
                        {{-- Header --}}
                        <div class="mb-7">
                            <h2 class="text-lg font-bold text-white tracking-tight">New Requisition</h2>
                            <p class="text-[11px] text-slate-400 mt-1 font-medium">Register new transmission to the hub</p>
                        </div>

                        {{-- Form --}}
                        <form method="POST" action="{{ route('supplier.orders.store') }}" class="space-y-4">
                            @csrf

                            {{-- Product Name --}}
                            <div class="space-y-1.5">
                                <label class="block text-xs font-semibold text-slate-400 ml-1">Asset Name</label>
                                <input type="text" name="product_name" value="{{ old('product_name') }}"
                                       class="w-full rounded-xl bg-white/[0.03] border border-white/5 text-[13px] text-white px-4 py-2.5 focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/5 outline-none transition-all placeholder:text-slate-700 shadow-inner"
                                       placeholder="e.g. Industrial Filter" required>
                            </div>

                            {{-- Quantity + Unit Price --}}
                            <div class="grid grid-cols-2 gap-3">
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-semibold text-slate-400 ml-1">Quantity</label>
                                    <input type="number" name="quantity" value="{{ old('quantity') }}"
                                           class="w-full rounded-xl bg-white/[0.03] border border-white/5 text-[13px] text-white px-4 py-2.5 focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/5 outline-none transition-all font-medium"
                                           placeholder="0" required>
                                </div>
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-semibold text-slate-400 ml-1">Unit Price</label>
                                    <input type="number" step="0.01" name="unit_price" value="{{ old('unit_price') }}"
                                           class="w-full rounded-xl bg-white/[0.03] border border-white/5 text-[13px] text-white px-4 py-2.5 focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/5 outline-none transition-all font-medium"
                                           placeholder="0.00" required>
                                </div>
                            </div>

                            {{-- Priority --}}
                            <div class="space-y-1.5">
                                <label class="block text-xs font-semibold text-slate-400 ml-1">Priority Level</label>
                                <div class="relative group">
                                    <select name="priority"
                                            class="w-full rounded-xl bg-white/[0.03] border border-white/5 text-[13px] text-white px-4 py-2.5 focus:border-indigo-500/50 outline-none cursor-pointer appearance-none font-medium">
                                        <option value="standard" class="bg-[#11101d]">Standard delivery</option>
                                        <option value="high" class="bg-[#11101d]">High priority</option>
                                        <option value="critical" class="bg-[#11101d]">Critical emergency</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-500 group-hover:text-indigo-400 transition-colors">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M19 9l-7 7-7-7" /></svg>
                                    </div>
                                </div>
                            </div>

                            {{-- Notes --}}
                            <div class="space-y-1.5">
                                <label class="block text-xs font-semibold text-slate-400 ml-1">Additional Notes</label>
                                <textarea name="notes" rows="2"
                                          class="w-full rounded-xl bg-white/[0.03] border border-white/5 text-[13px] text-white px-4 py-2.5 focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/5 outline-none resize-none placeholder:text-slate-700 transition-all font-medium"
                                          placeholder="Optional details...">{{ old('notes') }}</textarea>
                            </div>

                            {{-- Actions --}}
                            <div class="flex items-center justify-between pt-5 mt-2">
                                <a href="{{ route('supplier.orders.index') }}" class="text-xs font-semibold text-slate-500 hover:text-white transition-colors">
                                    Cancel
                                </a>
                                <button type="submit"
                                        class="px-7 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl font-bold text-xs transition-all shadow-lg shadow-indigo-600/20 active:scale-95 border border-white/10">
                                    Submit Order
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-center gap-2 opacity-20">
                <div class="h-px w-8 bg-slate-500"></div>
                <p class="text-[9px] font-bold text-slate-500 tracking-widest uppercase">Secure Entry</p>
                <div class="h-px w-8 bg-slate-500"></div>
            </div>
        </div>
    </div>
</x-app-layout>