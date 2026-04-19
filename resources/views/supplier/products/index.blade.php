<x-app-layout>
    <x-slot name="header">Inventory</x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8 antialiased">
        <div class="max-w-7xl mx-auto space-y-6">

            {{-- Compact Header --}}
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-xl font-extrabold text-white tracking-tight">Supply Catalog</h1>
                    <p class="text-[11px] text-slate-500 font-medium tracking-wide">Manage and monitor asset availability.</p>
                </div>
                <a href="{{ route('supplier.products.create') }}" 
                   class="px-5 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-[10px] font-black uppercase tracking-widest rounded-xl transition-all shadow-lg shadow-indigo-500/20 active:scale-95">
                    + Register Asset
                </a>
            </div>

            {{-- Premium Glass Table --}}
            <div class="bg-white/[0.02] border border-white/5 rounded-[1.5rem] shadow-2xl backdrop-blur-md overflow-hidden">
                <div class="px-6 py-4 border-b border-white/5 flex justify-between items-center bg-white/[0.01]">
                    <h3 class="text-sm font-bold text-white tracking-tight">Active Inventory</h3>
                    <form method="GET" class="relative group">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search SKU or name..." 
                               class="w-64 bg-white/[0.03] border border-white/10 rounded-xl px-4 py-2 text-[11px] text-white outline-none focus:border-indigo-500/50 transition-all">
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-white/[0.01]">
                                <th class="px-6 py-3 text-left text-[9px] font-black text-slate-500 uppercase tracking-widest">Asset Info</th>
                                <th class="px-6 py-3 text-center text-[9px] font-black text-slate-500 uppercase tracking-widest">Type</th>
                                <th class="px-6 py-3 text-center text-[9px] font-black text-slate-500 uppercase tracking-widest">Status</th>
                                <th class="px-6 py-3 text-center text-[9px] font-black text-slate-500 uppercase tracking-widest">Stock</th>
                                <th class="px-6 py-3 text-right text-[9px] font-black text-slate-500 uppercase tracking-widest">Unit Valuation</th>
                                <th class="px-6 py-3 text-right text-[9px] font-black text-slate-500 uppercase tracking-widest">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($products as $product)
                            <tr class="hover:bg-white/[0.03] transition-all group">
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-4">
                                        <div class="h-10 w-10 rounded-xl bg-white/5 border border-white/10 overflow-hidden flex-shrink-0 group-hover:border-indigo-500/30 transition-colors">
                                            @if($product->image_path)
                                                <img src="{{ asset('storage/' . $product->image_path) }}" class="h-full w-full object-cover">
                                            @else
                                                <div class="h-full w-full flex items-center justify-center text-slate-700 bg-indigo-500/[0.02]">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke-width="2"/></svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-bold text-white group-hover:text-indigo-300 text-[13px] leading-tight transition-colors">{{ $product->name }}</div>
                                            <div class="text-[9px] font-mono text-indigo-400/80 font-bold uppercase tracking-wider">SKU-{{ str_pad($product->id, 5, '0', STR_PAD_LEFT) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-3 text-center">
                                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-tighter">{{ $product->unit ?? 'pcs' }}</span>
                                </td>
                                <td class="px-6 py-3 text-center">
                                    @php
                                        $status = strtolower($product->status);
                                        $statusClass = match($status) {
                                            'available', 'active' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                            'pending' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                            default => 'bg-red-500/10 text-red-400 border-red-500/20',
                                        };
                                    @endphp
                                    <span class="px-3 py-1 text-[9px] font-black uppercase border {{ $statusClass }} rounded-full">
                                        {{ $product->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-center">
                                    <div class="flex flex-col items-center">
                                        <span class="font-black {{ $product->stock <= 10 ? 'text-red-400' : 'text-white' }} text-sm">
                                            {{ $product->stock }}
                                        </span>
                                        
                                        {{-- Low Stock Alert --}}
                                        @if($product->stock <= 10)
                                            <span class="flex items-center gap-1 mt-1">
                                                <span class="relative flex h-1.5 w-1.5">
                                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                                    <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-red-500"></span>
                                                </span>
                                                <span class="text-[8px] font-black text-red-500 uppercase tracking-widest">Low</span>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-3 text-right font-black text-white text-sm">₱{{ number_format($product->price, 2) }}</td>
                                <td class="px-6 py-3 text-right">
                                    <a href="{{ route('supplier.products.edit', $product) }}" class="p-2 inline-block bg-white/5 hover:bg-indigo-500/20 border border-white/5 rounded-lg text-slate-500 hover:text-indigo-400 transition-all">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="py-20 text-center text-[10px] font-bold text-slate-600 uppercase tracking-widest">No assets detected</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>