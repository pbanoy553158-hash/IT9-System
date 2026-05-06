<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <span class="text-[#5046e5] font-bold text-xs tracking-widest uppercase">Inventory</span>
            <span class="h-4 w-[1px] bg-white/10"></span>
            <span class="text-white font-medium tracking-tight text-lg">Product Control Center</span>
        </div>
    </x-slot>

    <style>
        .ocean-dark-panel {
            background: linear-gradient(145deg, #171629 0%, #0d0b1a 100%);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .btn-ocean {
            background: linear-gradient(135deg, #5046e5 0%, #3730a3 100%);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 12px rgba(80, 70, 229, 0.2);
        }

        .btn-ocean:hover {
            filter: brightness(1.1);
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(80, 70, 229, 0.3);
        }

        .status-text {
            font-size: 11px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .custom-select-dark {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.8rem center;
            background-size: 0.8em;
        }

        .row-glow:hover {
            background: linear-gradient(90deg, rgba(80, 70, 229, 0.04) 0%, transparent 100%);
        }

        /* --- STYLED PAGINATION --- */
        .pg-container nav { display: flex; gap: 6px; align-items: center; }
        
        .pg-container nav a, 
        .pg-container nav span[aria-current="page"] span,
        .pg-container nav span[aria-disabled="true"] span {
            background: rgba(255, 255, 255, 0.03) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #94a3b8 !important;
            padding: 6px 12px !important;
            border-radius: 8px !important;
            font-size: 11px !important;
            font-weight: 600 !important;
            transition: all 0.2s !important;
            text-decoration: none !important;
        }

        .pg-container nav a:hover {
            border-color: #5046e5 !important;
            color: #5046e5 !important;
            background: rgba(80, 70, 229, 0.1) !important;
        }

        .pg-container nav span[aria-current="page"] span {
            background: #5046e5 !important;
            border-color: #5046e5 !important;
            color: white !important;
            box-shadow: 0 4px 12px rgba(80, 70, 229, 0.3);
        }

        .pg-container svg { width: 14px !important; height: 14px !important; }
        .pg-container nav div:first-child { display: none !important; }
    </style>

    <div class="py-10 space-y-8 max-w-[1400px] mx-auto px-4">
        
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row justify-between items-end gap-6 px-4">
            <div>
                <h1 class="text-white font-semibold text-3xl tracking-tighter leading-none">Inventory Control</h1>
                <p class="text-slate-500 text-sm mt-2 italic font-medium">Manage, verify, and track global asset movements</p>
            </div>
            
            <div class="flex items-center gap-3 pb-1">
                <form action="{{ route('admin.products.index') }}" method="GET">
                    <select name="status" onchange="this.form.submit()" 
                            class="custom-select-dark bg-[#080712] border border-white/10 rounded-xl text-[11px] font-bold text-slate-400 py-2.5 px-4 pr-10 outline-none focus:border-[#5046e5]/50 cursor-pointer transition-all">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                        <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active Assets</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending Review</option>
                        <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected Items</option>
                    </select>
                </form>
                
                <a href="{{ route('admin.products.create') }}" 
                   class="btn-ocean px-6 py-3 rounded-xl text-white text-xs font-semibold tracking-wide transition-all inline-flex items-center">
                    Manual Entry
                </a>
            </div>
        </div>

        {{-- Table Section --}}
        <div class="ocean-dark-panel rounded-[2rem] shadow-2xl overflow-hidden mt-4 mx-2">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[12px] text-slate-500 border-b border-white/5 bg-white/[0.01] font-medium">
                            <th class="px-7 py-5">Asset Identification</th>
                            <th class="px-7 py-5">Supplier Node</th>
                            <th class="px-7 py-5 text-center">Valuation</th>
                            <th class="px-7 py-5 text-center">Lifecycle State</th>
                            <th class="px-7 py-5 text-right">Actions Control</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($products as $product)
                        <tr class="row-glow transition-colors group">
                            <td class="px-7 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-lg bg-[#0d0b1a] border border-white/5 overflow-hidden flex-shrink-0 group-hover:border-[#5046e5]/40 transition-all shadow-inner">
                                        @if($product->image_path)
                                            <img src="{{ asset('storage/' . $product->image_path) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-[8px] text-slate-700 font-bold uppercase tracking-tighter">No Data</div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-[13px] font-medium text-white group-hover:text-[#5046e5] transition-colors leading-tight mb-0.5">
                                            {{ $product->name }}
                                        </div>
                                        <div class="text-[10px] font-mono text-[#5046e5]/80 tracking-normal font-semibold uppercase">
                                            {{ $product->sku }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-7 py-5">
                                <div class="text-xs text-slate-300 font-medium leading-tight">{{ $product->supplier->name }}</div>
                                <div class="text-[10px] text-slate-500 mt-0.5 italic">{{ $product->category->name ?? 'Uncategorized' }}</div>
                            </td>
                            <td class="px-7 py-5 text-center">
                                <div class="text-xs font-semibold text-emerald-400 tracking-tight">₱{{ number_format($product->price, 2) }}</div>
                                <div class="text-[10px] mt-0.5 {{ $product->stock < 10 ? 'text-rose-500 font-bold' : 'text-slate-500' }}">Stock: {{ $product->stock }}</div>
                            </td>
                            <td class="px-7 py-5 text-center">
                                @php
                                    $statusColor = [
                                        'Active'   => 'text-emerald-400',
                                        'pending'  => 'text-amber-400',
                                        'Rejected' => 'text-rose-500',
                                    ][$product->status] ?? 'text-slate-400';
                                @endphp
                                <span class="status-text {{ $statusColor }} tracking-tight">
                                    <span class="w-1 h-1 rounded-full bg-current opacity-70"></span>
                                    {{ ucfirst($product->status ?? 'pending') }}
                                </span>
                            </td>
                            <td class="px-7 py-5 text-right">
                                <div class="flex justify-end gap-2">
                                    @if($product->status !== 'Active')
                                        <form action="{{ route('admin.products.approve', $product) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="w-8 h-8 flex items-center justify-center bg-emerald-500/5 hover:bg-emerald-500 text-emerald-500 hover:text-white rounded-lg transition-all border border-emerald-500/10 shadow-sm" title="Approve">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7" /></svg>
                                            </button>
                                        </form>
                                    @endif

                                    @if($product->status !== 'Rejected')
                                        <form action="{{ route('admin.products.reject', $product) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="w-8 h-8 flex items-center justify-center bg-rose-500/5 hover:bg-rose-500 text-rose-500 hover:text-white rounded-lg transition-all border border-rose-500/10 shadow-sm" title="Reject">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M6 18L18 6M6 6l12 12" /></svg>
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Erase asset record?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-8 h-8 flex items-center justify-center bg-white/5 hover:bg-white/10 text-slate-500 hover:text-white rounded-lg transition-all border border-white/5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{-- Footer / Pagination Section --}}
            <div class="px-7 py-5 bg-white/[0.01] border-t border-white/5 flex items-center justify-between">
                <div class="text-[9px] text-slate-500 font-bold uppercase tracking-widest">
                    Node Capacity: {{ $products->total() }} Units
                </div>
                <div class="pg-container">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>