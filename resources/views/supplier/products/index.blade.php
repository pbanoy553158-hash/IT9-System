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
                <a href="{{ route('supplier.orders.create') }}"
                   class="bg-indigo-600 hover:bg-indigo-500 text-white text-xs px-4 py-2 rounded-lg font-bold">
                    Register Asset
                </a>
            </div>

            {{-- Filter & Search Bar Section --}}
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between bg-white/[0.02] border border-white/5 p-4 rounded-2xl backdrop-blur-sm">
                <form action="{{ route('supplier.products.index') }}" method="GET" class="flex flex-1 flex-col md:flex-row gap-3 w-full">
                    {{-- Search Input --}}
                    <div class="relative flex-1">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-3.5 w-3.5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search SKU or name..." 
                               class="w-full bg-white/[0.03] border border-white/10 rounded-xl pl-9 pr-4 py-2 text-[11px] text-white outline-none focus:border-indigo-500/50 transition-all">
                    </div>

                    {{-- Category Filter --}}
                    <select name="category" onchange="this.form.submit()" 
                            class="bg-[#0d0d12] border border-white/10 rounded-xl px-4 py-2 text-[11px] text-slate-400 outline-none focus:border-indigo-500/50 transition-all cursor-pointer min-w-[150px]">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>

                    {{-- Action Buttons --}}
                    <div class="flex gap-2">
                        <button type="submit" class="px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl text-[10px] font-bold text-white uppercase tracking-widest transition-all">
                            Filter
                        </button>
                        @if(request()->has('search') || request()->has('category'))
                            <a href="{{ route('supplier.products.index') }}" class="px-4 py-2 bg-red-500/10 hover:bg-red-500/20 border border-red-500/20 rounded-xl text-[10px] font-bold text-red-400 uppercase tracking-widest transition-all flex items-center">
                                Clear
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Premium Glass Table --}}
            <div class="bg-white/[0.02] border border-white/5 rounded-[1.5rem] shadow-2xl backdrop-blur-md overflow-hidden">
                <div class="px-6 py-4 border-b border-white/5 flex justify-between items-center bg-white/[0.01]">
                    <h3 class="text-sm font-bold text-white tracking-tight">Active Inventory</h3>
                    <span class="text-[10px] text-slate-500 font-mono">Total Nodes: {{ $products->count() }}</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-white/[0.01]">
                                <th class="px-6 py-4 text-left text-[9px] font-black text-slate-500 uppercase tracking-widest">Asset Info</th>
                                <th class="px-6 py-4 text-center text-[9px] font-black text-slate-500 uppercase tracking-widest">Category</th>
                                <th class="px-6 py-4 text-center text-[9px] font-black text-slate-500 uppercase tracking-widest">Status</th>
                                <th class="px-6 py-4 text-center text-[9px] font-black text-slate-500 uppercase tracking-widest">Stock Level</th>
                                <th class="px-6 py-4 text-right text-[9px] font-black text-slate-500 uppercase tracking-widest">Unit Valuation</th>
                                <th class="px-6 py-4 text-right text-[9px] font-black text-slate-500 uppercase tracking-widest">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($products as $product)
                            <tr class="hover:bg-white/[0.03] transition-all group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="h-10 w-10 rounded-xl bg-white/5 border border-white/10 overflow-hidden flex-shrink-0 group-hover:border-indigo-500/30 transition-colors">
                                            @if($product->image_path)
                                                <img src="{{ asset('storage/' . $product->image_path) }}" class="h-full w-full object-cover">
                                            @else
                                                <div class="h-full w-full flex items-center justify-center text-slate-700 bg-indigo-500/[0.02]">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                        <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-bold text-white group-hover:text-indigo-300 text-[13px] leading-tight transition-colors">{{ $product->name }}</div>
                                            <div class="text-[9px] font-mono text-indigo-400/80 font-bold uppercase tracking-wider">{{ $product->sku }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-tighter bg-white/5 px-2 py-1 rounded-md border border-white/5">
                                        {{ $product->category->name ?? 'Uncategorized' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
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
                                <td class="px-6 py-4 text-center">
                                    <div class="flex flex-col items-center">
                                        <span class="font-black {{ $product->stock <= 10 ? 'text-red-400' : 'text-white' }} text-sm">
                                            {{ $product->stock }} <span class="text-[9px] text-slate-500">{{ $product->unit }}</span>
                                        </span>
                                        
                                        @if($product->stock <= 10)
                                            <span class="flex items-center gap-1 mt-1">
                                                <span class="relative flex h-1.5 w-1.5">
                                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                                    <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-red-500"></span>
                                                </span>
                                                <span class="text-[8px] font-black text-red-500 uppercase tracking-widest">Critical</span>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right font-black text-white text-sm">
                                    ₱{{ number_format($product->price, 2) }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        {{-- Edit Button --}}
                                        <a href="{{ route('supplier.products.edit', $product) }}" class="p-2 inline-block bg-white/5 hover:bg-indigo-500/20 border border-white/5 rounded-lg text-slate-500 hover:text-indigo-400 transition-all" title="Edit Node">
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                                <path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </a>

                                        {{-- Delete Button --}}
                                        <form action="{{ route('supplier.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Decommission this asset from the database? This action cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 inline-block bg-white/5 hover:bg-red-500/20 border border-white/5 rounded-lg text-slate-500 hover:text-red-400 transition-all" title="Delete Node">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                                    <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-20 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <svg class="h-10 w-10 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                        <span class="text-[10px] font-bold text-slate-600 uppercase tracking-widest">No assets found matching your criteria</span>
                                        <a href="{{ route('supplier.products.index') }}" class="text-[9px] text-indigo-400 hover:text-white underline uppercase font-bold">Reset Filters</a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Success Notification --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" 
                     class="fixed bottom-6 right-6 flex items-center p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl backdrop-blur-md shadow-2xl z-50">
                    <div class="flex items-center gap-3">
                        <div class="h-8 w-8 rounded-full bg-emerald-500/20 flex items-center justify-center">
                            <svg class="h-4 w-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <p class="text-[11px] font-bold text-emerald-400 uppercase tracking-widest">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>