<x-app-layout>
    <x-slot name="header">My Invoices</x-slot>

    <div class="min-h-screen bg-[#0d0b1a] py-8 px-6 font-['Inter'] antialiased">
        <div class="max-w-6xl mx-auto space-y-8">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <h1 class="text-3xl font-bold text-white tracking-tight">My Invoices</h1>
                    <p class="text-slate-400 mt-1">All generated invoices from your orders</p>
                </div>
            </div>

            <div class="bg-[#1b1931] border border-white/10 rounded-3xl shadow-2xl overflow-hidden">
                
                <div class="px-8 py-6 border-b border-white/10 flex justify-between items-center bg-white/[0.01]">
                    <h3 class="text-lg font-semibold text-white">Invoice History</h3>
                    
                    <form method="GET" class="relative w-80">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Search invoice or product..." 
                               class="w-full bg-[#121124] border border-white/10 rounded-2xl px-5 py-3 text-sm text-white placeholder:text-slate-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/30 outline-none transition-all">
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-white/[0.02]">
                                <th class="px-8 py-5 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Invoice</th>
                                <th class="px-8 py-5 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Product</th>
                                <th class="px-8 py-5 text-center text-xs font-medium text-slate-400 uppercase tracking-wider">Amount</th>
                                <th class="px-8 py-5 text-center text-xs font-medium text-slate-400 uppercase tracking-wider">Status</th>
                                <th class="px-8 py-5 text-right text-xs font-medium text-slate-400 uppercase tracking-wider">Date</th>
                                <th class="px-8 py-5 text-right text-xs font-medium text-slate-400 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @forelse($orders as $order)
                            <tr class="hover:bg-white/5 transition-colors group">
                                <td class="px-8 py-6 font-mono text-indigo-400">{{ $order->order_number }}</td>
                                <td class="px-8 py-6">
                                    <div class="font-medium text-white group-hover:text-indigo-300 transition-colors">{{ $order->product_name }}</div>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <div class="font-semibold text-white">₱{{ number_format($order->total_amount, 2) }}</div>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    @php
                                        $statusClass = match($order->status) {
                                            'Delivered' => 'bg-emerald-500/10 text-emerald-400 border-emerald-400/30',
                                            'Shipped'   => 'bg-indigo-500/10 text-indigo-400 border-indigo-400/30',
                                            'Pending'   => 'bg-amber-500/10 text-amber-400 border-amber-400/30',
                                            default     => 'bg-slate-500/10 text-slate-400 border-white/10',
                                        };
                                    @endphp
                                    <span class="px-5 py-1.5 text-xs font-medium rounded-2xl border {{ $statusClass }}">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right text-sm text-slate-400">
                                    {{ $order->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <a href="{{ route('supplier.invoices.show', $order) }}" 
                                       class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium rounded-2xl transition shadow-lg shadow-indigo-500/20 active:scale-95">
                                        View Invoice
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-20 text-center text-slate-500">
                                    No invoices generated yet.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-8 py-6 border-t border-white/10 flex justify-center">
                    {{ $orders->appends(request()->query())->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>