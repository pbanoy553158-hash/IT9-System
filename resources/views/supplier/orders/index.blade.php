    <x-app-layout>
        <x-slot name="header">
            <div class="text-xs font-semibold uppercase tracking-widest text-slate-400">
                Order Registry
            </div>
        </x-slot>

        <div class="space-y-8">

            {{-- HEADER --}}
            <div class="flex flex-col md:flex-row justify-between gap-6 md:items-end">

                <div>
                    <h2 class="text-2xl md:text-3xl font-semibold text-white">
                        Supplier Orders
                    </h2>
                    <p class="text-sm text-slate-400 mt-1">
                        Track, filter, and manage all purchase requisitions.
                    </p>
                </div>

                <a href="{{ route('supplier.orders.create') }}"
                class="px-5 py-3 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold uppercase tracking-widest rounded-xl transition">
                    + New Order
                </a>

            </div>

            {{-- FILTER BAR --}}
            <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">

                {{-- Search --}}
                <input type="text" name="search"
                    value="{{ request('search') }}"
                    placeholder="Search product or reference..."
                    class="w-full bg-slate-900 border border-slate-700 text-white rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500">

                {{-- Status Filter --}}
                <select name="status"
                        class="w-full bg-slate-900 border border-slate-700 text-white rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500">
                    <option value="">All Status</option>
                    <option value="pending" @selected(request('status')=='pending')>Pending</option>
                    <option value="approved" @selected(request('status')=='approved')>Approved</option>
                    <option value="rejected" @selected(request('status')=='rejected')>Rejected</option>
                    <option value="delivered" @selected(request('status')=='delivered')>Delivered</option>
                </select>

                {{-- Filter Button --}}
                <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-sm font-semibold uppercase tracking-widest">
                    Apply Filters
                </button>

            </form>

            {{-- TABLE --}}
            <div class="bg-slate-950 border border-white/10 rounded-2xl overflow-hidden">

                <div class="overflow-x-auto">

                    <table class="w-full text-sm">

                        {{-- HEADER --}}
                        <thead class="bg-white/5 text-slate-400 text-xs uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-4 text-left">Reference</th>
                                <th class="px-6 py-4 text-left">Product</th>
                                <th class="px-6 py-4 text-left">Qty</th>
                                <th class="px-6 py-4 text-left">Status</th>
                                <th class="px-6 py-4 text-right">Date</th>
                            </tr>
                        </thead>

                        {{-- BODY --}}
                        <tbody class="divide-y divide-white/5">

                            @forelse($orders as $order)
                                @php
                                    $status = strtolower($order->status);

                                    $badge = [
                                        'pending' => 'bg-yellow-500/10 text-yellow-400',
                                        'approved' => 'bg-green-500/10 text-green-400',
                                        'rejected' => 'bg-red-500/10 text-red-400',
                                        'delivered' => 'bg-indigo-500/10 text-indigo-400',
                                    ][$status] ?? 'bg-slate-500/10 text-slate-400';
                                @endphp

                                <tr class="hover:bg-white/5 transition">

                                    {{-- REF --}}
                                    <td class="px-6 py-5 font-mono text-xs text-emerald-400">
                                        ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                                    </td>

                                    {{-- PRODUCT --}}
                                    <td class="px-6 py-5 text-white font-medium">
                                        {{ $order->product_name }}
                                    </td>

                                    {{-- QTY --}}
                                    <td class="px-6 py-5 text-slate-300">
                                        {{ $order->quantity }}
                                    </td>

                                    {{-- STATUS --}}
                                    <td class="px-6 py-5">
                                        <span class="px-3 py-1 rounded-full text-[10px] font-semibold uppercase tracking-wider {{ $badge }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>

                                    {{-- DATE --}}
                                    <td class="px-6 py-5 text-right text-slate-400 text-xs">
                                        {{ $order->created_at->format('d M Y') }}
                                    </td>

                                </tr>

                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-16 text-slate-500">
                                        No orders found matching your filters.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>

                </div>
            </div>

            {{-- PAGINATION --}}
            <div class="text-slate-400">
                {{ $orders->appends(request()->query())->links() }}
            </div>

        </div>
    </x-app-layout>