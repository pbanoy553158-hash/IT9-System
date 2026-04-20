<x-app-layout>
    <x-slot name="header">Orders</x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8 antialiased">
        <div class="max-w-7xl mx-auto space-y-6">

            {{-- HEADER (MATCH PRODUCTS STYLE) --}}
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-xl font-extrabold text-white tracking-tight">Order Log</h1>
                    <p class="text-[11px] text-slate-500 font-medium tracking-wide">
                        Live supplier transactions
                    </p>
                </div>

                <a href="{{ route('supplier.orders.create') }}"
                   class="bg-indigo-600 hover:bg-indigo-500 text-white text-xs px-4 py-2 rounded-lg font-bold">
                    New Order
                </a>
            </div>

            {{-- FILTER BAR (MATCH PRODUCTS STYLE) --}}
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between bg-white/[0.02] border border-white/5 p-4 rounded-2xl backdrop-blur-sm">

                <form method="GET" class="flex flex-1 flex-col md:flex-row gap-3 w-full">

                    <select name="status"
                        class="bg-[#0d0d12] border border-white/10 rounded-xl px-4 py-2 text-[11px] text-slate-400 outline-none focus:border-indigo-500/50 transition-all cursor-pointer min-w-[180px]">

                        <option value="">All Status</option>
                        <option>Pending</option>
                        <option>Processing</option>
                        <option>Shipped</option>
                        <option>Delivered</option>
                        <option>Rejected</option>
                    </select>

                    <button type="submit"
                        class="px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl text-[10px] font-bold text-white uppercase tracking-widest transition-all">
                        Filter
                    </button>

                </form>
            </div>

            {{-- PREMIUM GLASS TABLE (MATCH PRODUCTS STYLE) --}}
            <div class="bg-white/[0.02] border border-white/5 rounded-[1.5rem] shadow-2xl backdrop-blur-md overflow-hidden">

                <div class="px-6 py-4 border-b border-white/5 flex justify-between items-center bg-white/[0.01]">
                    <h3 class="text-sm font-bold text-white tracking-tight">Order Records</h3>
                    <span class="text-[10px] text-slate-500 font-mono">
                        Total Orders: {{ $orders->count() }}
                    </span>
                </div>

                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead>
                            <tr class="bg-white/[0.01]">
                                <th class="px-6 py-4 text-left text-[9px] font-black text-slate-500 uppercase tracking-widest">
                                    Product Info
                                </th>

                                <th class="px-6 py-4 text-center text-[9px] font-black text-slate-500 uppercase tracking-widest">
                                    Status
                                </th>

                                <th class="px-6 py-4 text-right text-[9px] font-black text-slate-500 uppercase tracking-widest">
                                    Amount
                                </th>

                                <th class="px-6 py-4 text-right text-[9px] font-black text-slate-500 uppercase tracking-widest">
                                    Date
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-white/5">

                            @forelse($orders as $order)
                            <tr class="hover:bg-white/[0.03] transition-all group">

                                {{-- PRODUCT INFO --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">

                                        {{-- optional product image --}}
                                        <div class="h-10 w-10 rounded-xl bg-white/5 border border-white/10 overflow-hidden flex-shrink-0 group-hover:border-indigo-500/30 transition-colors">
                                            @if($order->product_image ?? false)
                                                <img src="{{ asset('storage/' . $order->product_image) }}"
                                                     class="h-full w-full object-cover">
                                            @else
                                                <div class="h-full w-full flex items-center justify-center text-slate-700">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>

                                        <div>
                                            <div class="font-bold text-white group-hover:text-indigo-300 text-[13px] transition-colors">
                                                {{ $order->product_name }}
                                            </div>

                                            <div class="text-[9px] font-mono text-indigo-400 font-bold uppercase tracking-wider">
                                                {{ $order->order_number }}
                                            </div>
                                        </div>

                                    </div>
                                </td>

                                {{-- STATUS --}}
                                <td class="px-6 py-4 text-center">
                                    <span class="text-[10px] font-bold uppercase px-3 py-1 rounded-full border
                                        @if($order->status == 'Pending') bg-amber-500/10 text-amber-400 border-amber-500/20
                                        @elseif($order->status == 'Processing') bg-blue-500/10 text-blue-400 border-blue-500/20
                                        @elseif($order->status == 'Shipped') bg-indigo-500/10 text-indigo-400 border-indigo-500/20
                                        @elseif($order->status == 'Delivered') bg-emerald-500/10 text-emerald-400 border-emerald-500/20
                                        @else bg-red-500/10 text-red-400 border-red-500/20
                                        @endif">
                                        {{ $order->status }}
                                    </span>
                                </td>

                                {{-- AMOUNT --}}
                                <td class="px-6 py-4 text-right font-black text-white text-sm">
                                    ₱{{ number_format($order->total_amount, 2) }}
                                </td>

                                {{-- DATE --}}
                                <td class="px-6 py-4 text-right text-[10px] text-slate-500">
                                    {{ $order->created_at->format('M d, Y') }}
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-20 text-center">
                                    <span class="text-[10px] font-bold text-slate-600 uppercase tracking-widest">
                                        No orders found
                                    </span>
                                </td>
                            </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>