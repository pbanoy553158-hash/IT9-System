<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <span class="text-[#5046e5] font-semibold text-xs tracking-widest uppercase">Commerce</span>
            <span class="h-4 w-[1px] bg-white/10"></span>
            <span class="text-white font-medium tracking-tight">Order Management</span>
        </div>
    </x-slot>

    <div class="py-6 space-y-8">
        <div class="flex flex-col md:flex-row justify-between items-center gap-6 bg-[#1b1931]/40 border border-white/5 p-8 rounded-[2.5rem] shadow-2xl relative overflow-hidden">
            <div class="relative z-10">
                <h1 class="text-white font-semibold text-3xl tracking-tighter">Recent Orders</h1>
                <p class="text-slate-400 text-sm mt-2 font-medium">Monitor and manage active purchase requests across the network.</p>
            </div>
            
            <div class="flex items-center gap-4 relative z-10">
                <span class="px-5 py-2.5 bg-[#5046e5]/10 text-[#5046e5] text-[11px] font-bold rounded-xl border border-[#5046e5]/20 flex items-center gap-2 uppercase tracking-wider">
                    <div class="w-2 h-2 bg-[#5046e5] rounded-full animate-pulse shadow-[0_0_8px_rgba(80,70,229,0.8)]"></div>
                    System Live
                </span>
            </div>
        </div>

        <div class="bg-[#1b1931] border border-white/10 rounded-[2rem] shadow-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-white/5 bg-white/[0.02]">
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Partner</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Order ID</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Product</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Total Amount</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Status</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-slate-500 uppercase tracking-widest text-right">Lifecycle Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($orders as $order)
                            <tr class="hover:bg-white/[0.01] transition-colors group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-[#0d0b1a] border border-white/5 flex items-center justify-center text-xs font-bold text-[#5046e5] group-hover:scale-105 transition-transform">
                                            {{ substr($order->user->name ?? 'U', 0, 1) }}
                                        </div>
                                        <span class="text-sm font-semibold text-white">{{ $order->user->name ?? 'Unknown User' }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="text-xs font-mono text-[#5046e5] bg-[#5046e5]/5 px-2 py-1 rounded-md">{{ $order->order_number }}</span>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="text-sm font-semibold text-slate-200">{{ $order->product_name }}</div>
                                    <div class="text-[10px] text-slate-500 mt-0.5 font-medium">Quantity: {{ $order->quantity }}</div>
                                </td>
                                <td class="px-8 py-6 text-sm font-semibold text-white">
                                    ${{ number_format($order->total_amount, 2) }}
                                </td>
                                <td class="px-8 py-6">
                                    @php
                                        $statusClasses = [
                                            'Pending'    => 'bg-amber-500/10 text-amber-500 border-amber-500/10',
                                            'Processing' => 'bg-blue-500/10 text-blue-500 border-blue-500/10',
                                            'Shipped'    => 'bg-indigo-500/10 text-indigo-500 border-indigo-500/10',
                                            'Delivered'  => 'bg-emerald-500/10 text-emerald-500 border-emerald-500/10',
                                            'Rejected'   => 'bg-rose-500/10 text-rose-500 border-rose-500/10',
                                        ][$order->status] ?? 'bg-slate-500/10 text-slate-400 border-white/5';
                                    @endphp
                                    <span class="px-3 py-1 text-[10px] font-bold border rounded-lg uppercase tracking-wider {{ $statusClasses }}">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" 
                                            class="bg-[#0d0b1a] border border-white/10 hover:border-[#5046e5]/50 rounded-xl text-[11px] font-bold py-2 pl-4 pr-9 text-slate-300 focus:ring-0 focus:outline-none cursor-pointer transition-all appearance-none">
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
                                    <div class="text-4xl mb-4 opacity-20">📦</div>
                                    <p class="text-slate-500 font-medium">No order history available</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($orders->hasPages())
                <div class="px-8 py-6 border-t border-white/5 bg-white/[0.01] flex items-center justify-between">
                    <div class="text-[11px] text-slate-500 font-medium uppercase tracking-wider">
                        Entry {{ $orders->firstItem() }} — {{ $orders->lastItem() }} 
                        <span class="mx-2 text-white/10">|</span>
                        Total {{ $orders->total() }}
                    </div>
                    
                    <div class="pagination-custom">
                        {{ $orders->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>