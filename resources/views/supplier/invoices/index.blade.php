<x-app-layout>
    <x-slot name="header">Invoices</x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8 antialiased">
        <div class="max-w-7xl mx-auto space-y-6">

            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-xl font-extrabold text-white tracking-tight">Billing & Invoices</h1>
                    <p class="text-[11px] text-slate-500 font-medium tracking-wide">Financial records and order reconciliations.</p>
                </div>
            </div>

            <div class="bg-white/[0.02] border border-white/5 rounded-2xl overflow-hidden">

                {{-- HEADER --}}
                <div class="p-4 border-b border-white/5 flex justify-between items-center">
                    <div class="text-white font-bold text-sm">Recent Invoices</div>
                    <form method="GET" action="{{ route('supplier.invoices.index') }}" class="relative group">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search invoice or product..." 
                            class="bg-[#0b0b10] border border-white/10 rounded-xl px-4 py-1.5 text-[11px] text-white outline-none focus:border-indigo-500/50 transition-all">
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="text-[10px] text-slate-500 uppercase bg-white/5">
                            <tr>
                                <th class="text-left px-6 py-3">Invoice Ref</th>
                                <th class="text-left px-6 py-3">Description</th>
                                <th class="text-center px-6 py-3">Amount</th>
                                <th class="text-center px-6 py-3">Status</th>
                                <th class="text-right px-6 py-3">Issued</th>
                                <th class="text-right px-6 py-3">Action</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-white/5">
                            @forelse($orders as $order)
                            <tr class="hover:bg-white/5 transition">
                                <td class="px-6 py-3 text-[11px] font-mono text-indigo-400">
                                    INV-{{ $order->order_number }}
                                </td>
                                <td class="px-6 py-3">
                                    {{-- FIXED: Accessing name via relationship --}}
                                    <div class="text-white font-semibold text-xs truncate">
                                        {{ $order->product->name ?? 'N/A' }}
                                    </div>
                                    <div class="text-[10px] text-slate-500">{{ $order->quantity }} Units</div>
                                </td>
                                <td class="px-6 py-3 text-center text-white font-bold text-xs">
                                    ₱{{ number_format($order->total_amount, 2) }}
                                </td>
                                <td class="px-6 py-3 text-center">
                                    <span class="text-[10px] px-2 py-1 rounded-full 
                                        @if($order->status=='Delivered') bg-green-500/10 text-green-400
                                        @elseif($order->status=='Shipped') bg-indigo-500/10 text-indigo-400
                                        @elseif($order->status=='Pending') bg-yellow-500/10 text-yellow-400
                                        @else bg-white/5 text-slate-400 @endif">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-right text-[10px] text-slate-500">
                                    {{ $order->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-3 text-right">
                                    <a href="{{ route('supplier.invoices.show', $order) }}" 
                                    class="bg-indigo-600 hover:bg-indigo-500 px-3 py-1 text-[10px] rounded-lg text-white transition inline-block">
                                        View
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-16 text-slate-500 text-xs">No invoice history</td>
                            </tr>
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