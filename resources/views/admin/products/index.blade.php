<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <span class="text-[#5046e5] font-semibold text-xs tracking-widest">Inventory</span>
            <span class="h-4 w-[1px] bg-white/10"></span>
            <span class="text-white font-medium tracking-tight">Product Control Center</span>
        </div>
    </x-slot>

    <style>
        /* Consistent vibrant violet button style */
        .btn-primary-violet {
            background: #5046e5;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 15px 0 rgba(80, 70, 229, 0.3);
        }

        .btn-primary-violet:hover {
            background: #4338ca;
            box-shadow: 0 6px 20px 0 rgba(80, 70, 229, 0.4);
            transform: translateY(-1px);
        }

        .custom-select-dark {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.8rem center;
            background-size: 0.9em;
        }
    </style>

    <div class="py-6 space-y-8">
        {{-- Header & Stats --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 bg-[#1b1931]/40 border border-white/5 p-8 rounded-[2.5rem] shadow-2xl relative overflow-hidden">
            <div class="relative z-10">
                <h1 class="text-white font-semibold text-3xl tracking-tighter">Inventory Control</h1>
                <p class="text-slate-400 text-sm mt-2 font-medium">Manage, verify, and filter global inventory assets.</p>
            </div>
            
            {{-- Status Filter & Action --}}
            <div class="flex items-center gap-4 relative z-10">
                <form action="{{ route('admin.products.index') }}" method="GET" class="flex items-center">
                    <select name="status" onchange="this.form.submit()" 
                            class="custom-select-dark bg-[#0d0b1a] border border-white/10 rounded-xl text-xs font-bold text-slate-300 py-3 px-5 pr-10 outline-none focus:border-[#5046e5]/50 cursor-pointer transition-all">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All status</option>
                        <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </form>
                
                {{-- Match Button Size and Style --}}
                <a href="{{ route('admin.products.create') }}" class="btn-primary-violet px-6 py-3 text-white rounded-xl font-bold text-xs tracking-wide transition-all active:scale-95 flex items-center gap-2">
                    <span class="opacity-70 font-normal text-lg leading-none">+</span>
                    Manual Entry
                </a>
            </div>
        </div>

        {{-- Product Grid/Table --}}
        <div class="bg-[#1b1931] border border-white/10 rounded-[2rem] shadow-2xl overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-white/5 bg-white/[0.02]">
                        <th class="p-5 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Identification</th>
                        <th class="p-5 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Ownership</th>
                        <th class="p-5 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Inventory</th>
                        <th class="p-5 text-[10px] font-bold text-slate-500 uppercase tracking-widest text-right">Lifecycle Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($products as $product)
                    <tr class="hover:bg-white/[0.01] transition-colors group">
                        <td class="p-5">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-[#0d0b1a] border border-white/5 overflow-hidden flex-shrink-0 transition-transform group-hover:scale-105">
                                    @if($product->image_path)
                                        <img src="{{ asset('storage/' . $product->image_path) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-[10px] text-slate-700">N/A</div>
                                    @endif
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-white group-hover:text-[#5046e5] transition-colors">{{ $product->name }}</div>
                                    <div class="text-[10px] font-mono text-[#5046e5] tracking-tighter">{{ $product->sku }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-5">
                            <div class="text-xs text-slate-300 font-medium">{{ $product->supplier->name }}</div>
                            <div class="text-[10px] text-slate-500 mt-0.5">{{ $product->category->name ?? 'Uncategorized' }}</div>
                        </td>
                        <td class="p-5">
                            <div class="text-sm font-bold text-white">₱{{ number_format($product->price, 2) }}</div>
                            <div class="text-[10px] mt-0.5 {{ $product->stock < 10 ? 'text-rose-500 font-bold' : 'text-slate-500' }}">Stock Level: {{ $product->stock }}</div>
                        </td>
                        <td class="p-5 text-right">
                            <div class="flex justify-end gap-2">
                                @if($product->status !== 'Active')
                                    <form action="{{ route('admin.products.approve', $product) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="w-9 h-9 flex items-center justify-center bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-500 rounded-xl transition-all border border-emerald-500/10" title="Approve">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif

                                @if($product->status !== 'Rejected')
                                    <form action="{{ route('admin.products.reject', $product) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="w-9 h-9 flex items-center justify-center bg-rose-500/10 hover:bg-rose-500/20 text-rose-500 rounded-xl transition-all border border-rose-500/10" title="Reject">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Archive this record?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-9 h-9 flex items-center justify-center bg-white/5 hover:bg-white/10 text-slate-500 hover:text-white rounded-xl transition-all border border-white/5">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            @if($products->hasPages())
                <div class="p-6 bg-white/[0.01] border-t border-white/5">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>