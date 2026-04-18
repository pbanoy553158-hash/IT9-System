<x-app-layout>
    <x-slot name="header">
        <span class="text-indigo-400 font-medium">Order</span> Management
    </x-slot>

    <div class="py-6">
        <!-- Header Card -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4 bg-[#1a1728]/70 border border-white/10 p-7 rounded-3xl backdrop-blur-md">
            <div>
                <h3 class="text-3xl font-light text-white tracking-tighter">Recent Orders</h3>
                <p class="text-slate-400 text-sm mt-2 font-light">Monitor and manage active purchase requests across the network.</p>
            </div>
            <span class="px-5 py-2 bg-emerald-500/10 text-emerald-400 text-xs font-medium rounded-2xl border border-emerald-500/20 flex items-center gap-2">
                <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></div>
                System Live
            </span>
        </div>

        <!-- Table Container -->
        <div class="bg-[#12141f]/80 border border-white/[0.06] rounded-3xl overflow-hidden backdrop-blur-sm shadow-2xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-white/5">
                            <th class="px-8 py-6 text-[11px] font-medium text-slate-500 tracking-widest uppercase">Partner</th>
                            <th class="px-8 py-6 text-[11px] font-medium text-slate-500 tracking-widest uppercase">Order ID</th>
                            <th class="px-8 py-6 text-[11px] font-medium text-slate-500 tracking-widest uppercase">Product</th>
                            <th class="px-8 py-6 text-[11px] font-medium text-slate-500 tracking-widest uppercase">Total Amount</th>
                            <th class="px-8 py-6 text-[11px] font-medium text-slate-500 tracking-widest uppercase">Status</th>
                            <th class="px-8 py-6 text-[11px] font-medium text-slate-500 tracking-widest uppercase text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/[0.03]">
                        @forelse($orders as $order)
                            <tr class="hover:bg-white/[0.015] transition-colors group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-sm font-medium text-indigo-300 group-hover:bg-indigo-500/20 transition-all">
                                            {{ substr($order->user->name ?? 'U', 0, 1) }}
                                        </div>
                                        <span class="text-sm font-medium text-slate-200">{{ $order->user->name ?? 'Unknown User' }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-xs font-mono text-slate-400">{{ $order->order_number }}</td>
                                <td class="px-8 py-6">
                                    <div class="text-sm text-slate-200">{{ $order->product_name }}</div>
                                    <div class="text-xs text-slate-500 mt-1">Qty: {{ $order->quantity }}</div>
                                </td>
                                <td class="px-8 py-6 text-sm font-medium text-white">
                                    ${{ number_format($order->total_amount, 2) }}
                                </td>
                                <td class="px-8 py-6">
                                    @php
                                        $statusClasses = [
                                            'Pending'    => 'bg-amber-400/10 text-amber-400 border-amber-400/20',
                                            'Processing' => 'bg-blue-400/10 text-blue-400 border-blue-400/20',
                                            'Shipped'    => 'bg-purple-400/10 text-purple-400 border-purple-400/20',
                                            'Delivered'  => 'bg-emerald-400/10 text-emerald-400 border-emerald-400/20',
                                            'Rejected'   => 'bg-red-400/10 text-red-400 border-red-400/20',
                                        ][$order->status] ?? 'bg-slate-500/10 text-slate-400 border-slate-500/20';
                                    @endphp
                                    <span class="inline-block px-4 py-1.5 text-xs font-medium border rounded-2xl {{ $statusClasses }}">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" 
                                            class="bg-[#0f111a] border border-white/10 hover:border-white/20 rounded-xl text-xs py-2 pl-4 pr-9 text-slate-300 focus:outline-none focus:border-indigo-500 cursor-pointer transition-all">
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
                                <td colspan="6" class="px-8 py-24 text-center">
                                    <div class="text-4xl mb-4 opacity-30">📭</div>
                                    <p class="text-slate-400">No orders found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($orders->hasPages())
                <div class="px-8 py-5 border-t border-white/5 bg-black/30 flex items-center justify-between">
                    <div class="text-xs text-slate-500">
                        Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} 
                        of {{ $orders->total() }} orders
                    </div>
                    
                    <div class="flex items-center gap-2">
                        {{ $orders->links('pagination::tailwind') }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>