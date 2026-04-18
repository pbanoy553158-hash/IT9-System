<x-app-layout>
    {{-- Background: Deep Midnight Purple --}}
    <div class="min-h-[calc(100vh-64px)] bg-[#0d0b1a] flex flex-col justify-center py-4 px-4 font-['Inter'] antialiased">
        
        <div class="max-w-md mx-auto w-full">
            {{-- Compact Back Link --}}
            <div class="mb-4">
                <a href="{{ route('supplier.orders.index') }}"
                   class="text-[11px] font-bold text-slate-500 hover:text-[#5851f2] transition flex items-center gap-2 uppercase tracking-widest">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Archive
                </a>
            </div>

            {{-- Form Card: Indigo/Purple background with Violet Glow --}}
            <div class="bg-[#1b1931] border border-white/10 rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.5),0_0_20px_rgba(88,81,242,0.1)] overflow-hidden">
                <div class="p-6 md:p-8">
                    {{-- Header --}}
                    <div class="mb-6">
                        <h2 class="text-lg font-bold text-white tracking-tight">New Requisition</h2>
                        <p class="text-xs text-slate-400 mt-1 font-medium">Log transmission details to the hub.</p>
                    </div>

                    {{-- Form --}}
                    <form method="POST" action="{{ route('supplier.orders.store') }}" class="space-y-4">
                        @csrf

                        {{-- Product Name --}}
                        <div class="space-y-1.5">
                            <label class="block text-[11px] font-semibold text-slate-400">Product Name</label>
                            {{-- Input BG: Dark Navy Purple --}}
                            <input type="text" name="product_name" value="{{ old('product_name') }}"
                                   class="w-full rounded-lg bg-[#121124] border border-white/5 text-sm text-white px-3 py-2.5 focus:ring-1 focus:ring-[#5851f2]/50 focus:border-[#5851f2]/50 outline-none transition-all placeholder:text-slate-700"
                                   placeholder="Item name..." required>
                        </div>

                        {{-- Quantity + Unit Price --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="block text-[11px] font-semibold text-slate-400">Quantity</label>
                                <input type="number" name="quantity" value="{{ old('quantity') }}"
                                       class="w-full rounded-lg bg-[#121124] border border-white/5 text-sm text-white px-3 py-2.5 focus:ring-1 focus:ring-[#5851f2]/50 outline-none transition-all"
                                       placeholder="0" required>
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-[11px] font-semibold text-slate-400">Unit Price</label>
                                <input type="number" step="0.01" name="unit_price" value="{{ old('unit_price') }}"
                                       class="w-full rounded-lg bg-[#121124] border border-white/5 text-sm text-white px-3 py-2.5 focus:ring-1 focus:ring-[#5851f2]/50 outline-none transition-all"
                                       placeholder="0.00" required>
                            </div>
                        </div>

                        {{-- Priority --}}
                        <div class="space-y-1.5">
                            <label class="block text-[11px] font-semibold text-slate-400">Priority Level</label>
                            <select name="priority"
                                    class="w-full rounded-lg bg-[#121124] border border-white/5 text-sm text-white px-3 py-2.5 focus:ring-1 focus:ring-[#5851f2]/50 outline-none cursor-pointer appearance-none">
                                <option value="standard">Standard</option>
                                <option value="high">High Priority</option>
                                <option value="critical">Critical</option>
                            </select>
                        </div>

                        {{-- Notes --}}
                        <div class="space-y-1.5">
                            <label class="block text-[11px] font-semibold text-slate-400">Notes</label>
                            <textarea name="notes" rows="2"
                                      class="w-full rounded-lg bg-[#121124] border border-white/5 text-sm text-white px-3 py-2.5 focus:ring-1 focus:ring-[#5851f2]/50 outline-none resize-none placeholder:text-slate-700"
                                      placeholder="Optional notes...">{{ old('notes') }}</textarea>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex items-center justify-between pt-4 border-t border-white/5 mt-2">
                            <a href="{{ route('supplier.orders.index') }}" class="text-xs font-medium text-slate-500 hover:text-white transition">
                                Cancel
                            </a>
                            {{-- Button: Signature Violet/Blue --}}
                            <button type="submit"
                                    class="px-6 py-2.5 bg-[#5851f2] hover:bg-[#4a44d1] text-white rounded-lg font-bold text-xs transition shadow-lg shadow-indigo-600/20 active:scale-95">
                                Submit Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <p class="text-center text-[10px] font-bold text-slate-700 mt-6 tracking-[0.2em] uppercase">
                Secure Entry Terminal
            </p>
        </div>
    </div>
</x-app-layout>