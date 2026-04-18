<x-app-layout>
    <x-slot name="header">Product Inventory</x-slot>

    <div class="min-h-screen bg-[#0d0b1a] py-8 px-6 font-['Inter'] antialiased">
        <div class="max-w-6xl mx-auto space-y-8">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <h1 class="text-3xl font-bold text-white tracking-tight">Supply Catalog</h1>
                    <p class="text-slate-400 mt-1 font-medium">Manage your items and supply availability</p>
                </div>

                <a href="{{ route('supplier.products.create') }}" 
                   class="px-7 py-3.5 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold rounded-2xl flex items-center gap-3 transition-all active:scale-95 shadow-lg shadow-indigo-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Register New Product
                </a>
            </div>

            <div class="bg-[#1b1931] border border-white/10 rounded-3xl shadow-2xl overflow-hidden">
                
                <div class="px-8 py-6 border-b border-white/10 flex justify-between items-center bg-white/[0.01]">
                    <h3 class="text-lg font-semibold text-white">Active Inventory</h3>
                    
                    <form method="GET" class="relative w-80">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search SKU or name..." 
                               class="w-full bg-[#121124] border border-white/10 rounded-2xl px-5 py-3 text-sm text-white placeholder:text-slate-500 focus:border-indigo-500 outline-none transition-all">
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-white/[0.02]">
                                <th class="px-8 py-5 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Product Info</th>
                                <th class="px-8 py-5 text-center text-xs font-medium text-slate-400 uppercase tracking-wider">Unit Type</th>
                                <th class="px-8 py-5 text-center text-xs font-medium text-slate-400 uppercase tracking-wider">Status</th>
                                <th class="px-8 py-5 text-center text-xs font-medium text-slate-400 uppercase tracking-wider">Stock</th>
                                <th class="px-8 py-5 text-right text-xs font-medium text-slate-400 uppercase tracking-wider">Unit Price</th>
                                <th class="px-8 py-5 text-right text-xs font-medium text-slate-400 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @forelse($products as $product)
                            <tr class="hover:bg-white/5 transition-colors group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="h-12 w-12 rounded-2xl bg-[#121124] border border-white/10 overflow-hidden flex-shrink-0">
                                            @if($product->image_path)
                                                <img src="{{ asset('storage/' . $product->image_path) }}" class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-500">
                                            @else
                                                <div class="h-full w-full flex items-center justify-center text-slate-700 bg-indigo-500/5">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-medium text-white group-hover:text-indigo-300 transition-colors">{{ $product->name }}</div>
                                            <div class="text-[10px] font-mono text-indigo-400 mt-1 uppercase tracking-tighter">SKU-{{ str_pad($product->id, 5, '0', STR_PAD_LEFT) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-center text-sm text-slate-400">
                                    {{ $product->unit ?? 'pcs' }}
                                </td>
                                <td class="px-8 py-6 text-center">
                                    @php
                                        $currentStatus = strtolower($product->status);
                                        // Dynamic color logic: Green for Available/Active, Red for anything else
                                        $isPositive = ($currentStatus === 'available' || $currentStatus === 'active');
                                        
                                        $statusClass = $isPositive 
                                            ? 'bg-emerald-500/10 text-emerald-400 border-emerald-400/30' 
                                            : 'bg-red-500/10 text-red-400 border-red-500/30';
                                    @endphp
                                    <span class="px-5 py-1.5 text-[10px] font-bold uppercase tracking-widest rounded-2xl border {{ $statusClass }}">
                                        {{ $product->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <div class="text-sm font-semibold {{ $product->stock < 10 ? 'text-amber-400' : 'text-white' }}">
                                        {{ $product->stock }}
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-right font-bold text-white tabular-nums">
                                    ₱{{ number_format($product->price, 2) }}
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('supplier.products.edit', $product) }}" class="p-2 hover:bg-indigo-500/20 rounded-xl text-slate-400 hover:text-indigo-400 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-20 text-center text-slate-500">No products found in your catalog.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-8 py-6 border-t border-white/10 flex justify-center bg-black/20">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>