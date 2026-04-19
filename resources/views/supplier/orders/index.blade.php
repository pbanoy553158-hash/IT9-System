<x-app-layout>
    <x-slot name="header">Orders</x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto space-y-6">

            {{-- HEADER --}}
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-xl font-bold text-white">Order Log</h1>
                    <p class="text-[11px] text-slate-500">Live supplier transactions</p>
                </div>

                <a href="{{ route('supplier.orders.create') }}"
                   class="bg-indigo-600 hover:bg-indigo-500 text-white text-xs px-4 py-2 rounded-lg font-bold">
                    New Order
                </a>
            </div>

            {{-- FILTER --}}
            <form method="GET" class="flex gap-3">
                <select name="status" class="bg-[#0f0d1d] text-white text-xs px-3 py-2 rounded-lg">
                    <option value="">All Status</option>
                    <option>Pending</option>
                    <option>Processing</option>
                    <option>Shipped</option>
                    <option>Delivered</option>
                    <option>Rejected</option>
                </select>

                <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-xs">
                    Filter
                </button>
            </form>

            {{-- TABLE --}}
            <div class="bg-white/[0.02] border border-white/5 rounded-xl overflow-hidden">

                <table class="w-full">
                    <thead>
                        <tr class="text-[10px] text-slate-500 uppercase">
                            <th class="p-4 text-left">Product</th>
                            <th class="p-4 text-center">Status</th>
                            <th class="p-4 text-right">Amount</th>
                            <th class="p-4 text-right">Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($orders as $order)
                        <tr class="border-t border-white/5 hover:bg-white/[0.03]">

                            <td class="p-4 text-white text-sm">
                                {{ $order->product_name }}
                                <div class="text-[9px] text-indigo-400">{{ $order->order_number }}</div>
                            </td>

                            <td class="p-4 text-center text-xs text-slate-300">
                                {{ $order->status }}
                            </td>

                            <td class="p-4 text-right text-white">
                                ₱{{ number_format($order->total_amount, 2) }}
                            </td>

                            <td class="p-4 text-right text-[10px] text-slate-500">
                                {{ $order->created_at->format('M d, Y') }}
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-10 text-slate-600 text-xs">
                                No orders found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>

            </div>

        </div>
    </div>
</x-app-layout>