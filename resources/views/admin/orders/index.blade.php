<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <span class="text-[#5046e5] font-bold text-xs tracking-widest uppercase">Commerce</span>
            <span class="h-4 w-[1px] bg-white/10"></span>
            <span class="text-white font-medium tracking-tight text-lg">Order Management</span>
        </div>
    </x-slot>

    <style>
        .ocean-dark-panel {
            background: linear-gradient(145deg, #171629 0%, #0d0b1a 100%);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
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
            background-position: right 0.7rem center;
            background-size: 0.7em;
        }

        .row-glow:hover {
            background: linear-gradient(90deg, rgba(80, 70, 229, 0.04) 0%, transparent 100%);
        }
    </style>

    <div class="py-8 space-y-6 max-w-[1400px] mx-auto px-8">
        
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row justify-between items-end gap-6 px-4">
            <div>
                <h1 class="text-white font-semibold text-2xl tracking-tighter leading-none">Recent Orders</h1>
                <p class="text-slate-500 text-sm mt-2 italic font-medium">Monitor and manage active purchase requests across the network</p>
            </div>
            
            <div class="pb-1">
                <span class="px-4 py-2 bg-[#5046e5]/10 text-[#5046e5] text-[11px] font-bold rounded-lg border border-[#5046e5]/20 flex items-center gap-2">
                    <div class="w-1.5 h-1.5 bg-[#5046e5] rounded-full animate-pulse shadow-[0_0_8px_rgba(80,70,229,0.8)]"></div>
                    System Online
                </span>
            </div>
        </div>

        {{-- Main Data Table --}}
        <div class="ocean-dark-panel rounded-[1.8rem] shadow-2xl overflow-hidden mt-2 mx-2">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[12px] text-slate-500 border-b border-white/5 bg-white/[0.01] font-medium">
                            <th class="px-7 py-4">Client Node</th>
                            <th class="px-7 py-4">Asset Record</th>
                            <th class="px-7 py-4 text-center">Lifecycle State</th>
                            <th class="px-7 py-4 text-center">Valuation</th>
                            <th class="px-7 py-4 text-right">Process Control</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($orders as $order)
                            <tr class="row-glow transition-colors group">
                                <td class="px-7 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-9 h-9 rounded-lg bg-[#0d0b1a] border border-white/5 flex items-center justify-center text-[10px] font-black text-[#5046e5] group-hover:border-[#5046e5]/30 transition-all shadow-inner">
                                            {{ strtoupper(substr($order->user->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-normal text-white group-hover:text-[#5046e5] transition-colors tracking-tight leading-tight">
                                                {{ $order->user->name ?? 'Unknown User' }}
                                            </div>
                                            <div class="text-[9px] font-medium text-slate-500 mt-0.5 tracking-tight italic">Identity Verified</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-7 py-5">
                                    <div class="text-sm font-semibold text-slate-200 leading-tight">{{ $order->product_name }}</div>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-[9px] font-mono text-[#5046e5]/90 bg-[#5046e5]/10 px-1.5 py-0.5 rounded border border-[#5046e5]/10">{{ $order->order_number }}</span>
                                        <span class="text-[9px] text-slate-500 font-bold uppercase tracking-widest">Qty: {{ $order->quantity }}</span>
                                    </div>
                                </td>
                                <td class="px-7 py-5 text-center">
                                    @php
                                        $statusColor = [
                                            'Pending'    => 'text-amber-400',
                                            'Processing' => 'text-blue-400',
                                            'Shipped'    => 'text-indigo-400',
                                            'Delivered'  => 'text-emerald-400',
                                            'Rejected'   => 'text-rose-500',
                                        ][$order->status] ?? 'text-slate-400';
                                    @endphp
                                    <span class="status-text {{ $statusColor }} tracking-tight">
                                        <span class="w-1 h-1 rounded-full bg-current opacity-70"></span>
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="px-7 py-5 text-center">

                                    <span class="text-xs font-semibold text-emerald-400 tracking-tight">
                                        ₱{{ number_format($order->total_amount, 2) }}
                                    </span>
                                </td>
                                <td class="px-7 py-5 text-right">
                                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" 
                                            class="custom-select-dark bg-[#080712] border border-white/10 hover:border-[#5046e5]/50 rounded-lg text-[10px] font-semibold py-1.5 pl-3 pr-8 text-slate-300 focus:ring-0 focus:outline-none cursor-pointer transition-all tracking-tight">
                                            @foreach(['Pending', 'Processing', 'Shipped', 'Delivered', 'Rejected'] as $status)
                                                <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>
                                                    {{ $status }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-20 text-center">
                                    <p class="text-slate-600 text-[11px] italic font-medium">No active records detected in network stream</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($orders->hasPages())
                <div class="px-7 py-5 border-t border-white/5 bg-white/[0.01] flex items-center justify-between">
                    <div class="text-[9px] text-slate-500 font-bold uppercase tracking-widest">
                        Network Capacity: {{ $orders->total() }} Units
                    </div>
                    
                    <div class="pagination-custom text-[10px]">
                        {{ $orders->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>