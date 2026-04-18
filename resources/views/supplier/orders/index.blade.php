<x-app-layout>
    <x-slot name="header">My Orders</x-slot>

    <div class="py-8 px-6">
        <div class="max-w-6xl mx-auto space-y-8">

            <!-- Header Section -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <h1 class="text-3xl font-semibold text-white tracking-tight">My Orders</h1>
                    <p class="text-slate-400 mt-1">Track and manage your purchase requisitions</p>
                </div>

                <a href="{{ route('supplier.orders.create') }}" 
                   class="px-6 py-3 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold rounded-2xl flex items-center gap-3 transition-all active:scale-95 shadow-lg shadow-indigo-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    New Order
                </a>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="bg-[#1b1931] border border-white/10 rounded-3xl p-6">
                    <p class="text-xs font-medium text-slate-400 uppercase tracking-widest">Total Orders</p>
                    <p class="text-4xl font-bold text-white mt-3 tracking-tighter">{{ $orders->total() }}</p>
                </div>
                <div class="bg-[#1b1931] border border-white/10 rounded-3xl p-6">
                    <p class="text-xs font-medium text-amber-400 uppercase tracking-widest">Pending</p>
                    <p class="text-3xl font-bold text-white mt-3">{{ $orders->where('status', 'Pending')->count() }}</p>
                </div>
                <div class="bg-[#1b1931] border border-white/10 rounded-3xl p-6">
                    <p class="text-xs font-medium text-indigo-400 uppercase tracking-widest">Shipped</p>
                    <p class="text-3xl font-bold text-white mt-3">{{ $orders->where('status', 'Shipped')->count() }}</p>
                </div>
                <div class="bg-[#1b1931] border border-white/10 rounded-3xl p-6">
                    <p class="text-xs font-medium text-emerald-400 uppercase tracking-widest">Delivered</p>
                    <p class="text-3xl font-bold text-white mt-3">{{ $orders->where('status', 'Delivered')->count() }}</p>
                </div>
            </div>

            <!-- Orders Table -->
            <div class="bg-[#1b1931] border border-white/10 rounded-3xl shadow-2xl overflow-hidden">
                
                <!-- Table Header -->
                <div class="px-8 py-6 border-b border-white/10 flex flex-col sm:flex-row justify-between items-center gap-4 bg-white/[0.01]">
                    <h3 class="text-lg font-semibold text-white">All Orders</h3>
                    
                    <form method="GET" class="w-full sm:w-80">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Search by product or order number..." 
                               class="w-full bg-[#121124] border border-white/10 rounded-2xl px-5 py-3 text-sm text-white placeholder:text-slate-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/30 outline-none transition-all">
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-white/[0.015]">
                                <th class="px-8 py-5 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Order Details</th>
                                <th class="px-8 py-5 text-center text-xs font-medium text-slate-400 uppercase tracking-wider">Status</th>
                                <th class="px-8 py-5 text-right text-xs font-medium text-slate-400 uppercase tracking-wider">Amount</th>
                                <th class="px-8 py-5 text-right text-xs font-medium text-slate-400 uppercase tracking-wider">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @forelse($orders as $order)
                            <tr class="hover:bg-white/5 transition-colors group">
                                <td class="px-8 py-6">
                                    <div class="font-medium text-white group-hover:text-indigo-300 transition-colors">
                                        {{ $order->product_name }}
                                    </div>
                                    <div class="text-xs font-mono text-indigo-400 mt-1">
                                        {{ $order->order_number }}
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    @php
                                        $statusClass = match($order->status) {
                                            'Delivered' => 'bg-emerald-500/10 text-emerald-400 border border-emerald-400/30',
                                            'Shipped'   => 'bg-indigo-500/10 text-indigo-400 border border-indigo-400/30',
                                            'Pending'   => 'bg-amber-500/10 text-amber-400 border border-amber-400/30',
                                            'Rejected'  => 'bg-red-500/10 text-red-400 border border-red-400/30',
                                            default     => 'bg-slate-500/10 text-slate-400 border border-white/10',
                                        };
                                    @endphp
                                    <span class="px-5 py-1.5 text-xs font-medium rounded-2xl border {{ $statusClass }}">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="font-semibold text-white">₱{{ number_format($order->total_amount, 2) }}</div>
                                    <div class="text-xs text-slate-500">{{ $order->quantity }} units</div>
                                </td>
                                <td class="px-8 py-6 text-right text-sm text-slate-400">
                                    {{ $order->created_at->format('M d, Y') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-20 text-center text-slate-500">
                                    No orders found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($orders->hasPages())
                <div class="px-8 py-6 border-t border-white/10 bg-black/30 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-xs text-slate-500">
                        Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} 
                        of {{ $orders->total() }} orders
                    </div>
                    
                    <div>
                        {{ $orders->appends(request()->query())->links() }}
                    </div>
                </div>
                @endif

            </div>

        </div>
    </div>
</x-app-layout>