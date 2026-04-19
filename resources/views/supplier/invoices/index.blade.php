<x-app-layout>
    <x-slot name="header">Invoices</x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8 antialiased">
        <div class="max-w-7xl mx-auto space-y-6">

            {{-- Compact Header --}}
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-xl font-extrabold text-white tracking-tight">Billing & Invoices</h1>
                    <p class="text-[11px] text-slate-500 font-medium tracking-wide">Financial records and order reconciliations.</p>
                </div>
            </div>

            {{-- Premium Glass Table --}}
            <div class="bg-white/[0.02] border border-white/5 rounded-[1.5rem] shadow-2xl backdrop-blur-md overflow-hidden">
                <div class="px-6 py-4 border-b border-white/5 flex justify-between items-center bg-white/[0.01]">
                    <h3 class="text-sm font-bold text-white tracking-tight">Recent Invoices</h3>
                    <form method="GET" class="relative group">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search invoice #..." 
                               class="w-64 bg-white/[0.03] border border-white/10 rounded-xl px-4 py-2 text-[11px] text-white outline-none focus:border-indigo-500/50 transition-all">
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-white/[0.01]">
                                <th class="px-6 py-3 text-left text-[9px] font-black text-slate-500 uppercase tracking-widest">Invoice Ref</th>
                                <th class="px-6 py-3 text-left text-[9px] font-black text-slate-500 uppercase tracking-widest">Description</th>
                                <th class="px-6 py-3 text-center text-[9px] font-black text-slate-500 uppercase tracking-widest">Amount</th>
                                <th class="px-6 py-3 text-center text-[9px] font-black text-slate-500 uppercase tracking-widest">Payment Status</th>
                                <th class="px-6 py-3 text-right text-[9px] font-black text-slate-500 uppercase tracking-widest">Date Issued</th>
                                <th class="px-6 py-3 text-right text-[9px] font-black text-slate-500 uppercase tracking-widest">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($orders as $order)
                            <tr class="hover:bg-white/[0.03] transition-all group">
                                <td class="px-6 py-3 text-[11px] font-mono font-black text-indigo-400 uppercase tracking-tighter">
                                    INV-{{ $order->order_number }}
                                </td>
                                <td class="px-6 py-3">
                                    <div class="text-[11px] font-bold text-white leading-tight">{{ $order->product_name }}</div>
                                    <div class="text-[9px] font-bold text-slate-600 uppercase">{{ $order->quantity }} Units</div>
                                </td>
                                <td class="px-6 py-3 text-center font-black text-white text-[13px]">
                                    ₱{{ number_format($order->total_amount, 2) }}
                                </td>
                                <td class="px-6 py-3 text-center">
                                    @php
                                        $statusClass = match($order->status) {
                                            'Delivered' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                            'Shipped'   => 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20',
                                            'Pending'   => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                            default     => 'bg-white/5 text-slate-400 border-white/10',
                                        };
                                    @endphp
                                    <span class="px-3 py-1 text-[9px] font-black uppercase tracking-tighter rounded-full border {{ $statusClass }}">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-right text-[10px] font-bold text-slate-500">
                                    {{ $order->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-3 text-right">
                                    <a href="{{ route('supplier.invoices.show', $order) }}" 
                                       class="text-[9px] font-black text-indigo-400 hover:text-white transition-colors uppercase tracking-widest px-3 py-1.5 bg-indigo-500/5 hover:bg-indigo-500 rounded-lg border border-indigo-500/20">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="py-20 text-center text-[10px] font-bold text-slate-600 uppercase tracking-widest">No invoice history</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($orders->hasPages())
                <div class="px-6 py-4 border-t border-white/5 bg-white/[0.01]">
                    {{ $orders->appends(request()->query())->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>