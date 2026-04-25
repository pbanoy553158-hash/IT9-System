<x-app-layout>
    <x-slot name="header">Orders</x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8 antialiased">
        <div class="max-w-7xl mx-auto space-y-6">

            {{-- HEADER --}}
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-xl font-extrabold text-white">Order Log</h1>
                    <p class="text-[11px] text-slate-500">Live supplier transactions</p>
                </div>

                <a href="{{ route('supplier.orders.create') }}"
                   class="bg-indigo-600 hover:bg-indigo-500 text-white text-xs px-4 py-2 rounded-lg font-bold">
                    + New Order
                </a>
            </div>

            {{-- FILTER --}}
            <div class="bg-white/[0.02] border border-white/5 p-4 rounded-2xl">
                <form method="GET" class="flex gap-3">
                    <select name="status"
                        class="bg-[#0b0b10] border border-white/10 text-white text-xs rounded-xl px-4 py-2">
                        <option value="">All Status</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Processing" {{ request('status') == 'Processing' ? 'selected' : '' }}>Processing</option>
                        <option value="Shipped" {{ request('status') == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="Delivered" {{ request('status') == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>

                    <button type="submit"
                        class="bg-white/5 px-4 py-2 text-xs text-white rounded-xl hover:bg-white/10">
                        Filter
                    </button>
                </form>
            </div>

            <div class="bg-white/[0.02] border border-white/5 rounded-2xl overflow-hidden">

                <div class="p-4 border-b border-white/5 flex justify-between items-center">
                    <div class="text-white font-bold text-sm">Orders</div>
                    <div class="text-slate-500 text-xs">Total: {{ $orders->total() }}</div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="text-[10px] text-slate-500 uppercase bg-white/5">
                            <tr>
                                <th class="text-left px-6 py-3">Product</th>
                                <th class="text-center px-6 py-3">Status</th>
                                <th class="text-right px-6 py-3">Amount</th>
                                <th class="text-right px-6 py-3">Action</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-white/5">
                            @forelse($orders as $order)
                                @php
                                    $item = $order->items->first();
                                    $product = $item?->product;
                                    $isInactive = $product && $product->status === 'Inactive';
                                @endphp

                                <tr class="hover:bg-white/5 transition">
                                    <td class="px-6 py-3">
                                        <div class="flex items-center gap-3">
                                            {{-- IMAGE WITH INACTIVE INDICATOR --}}
                                            <div class="h-12 w-12 rounded-lg overflow-hidden bg-black border border-white/10 flex-shrink-0 relative">
                                                @if($product && $product->image_path)
                                                    @if($isInactive)
                                                        <div class="absolute inset-0 z-10 bg-red-600/40 flex items-center justify-center">
                                                            <span class="text-[7px] font-black text-white uppercase tracking-tighter">Inactive</span>
                                                        </div>
                                                    @endif
                                                    <img src="{{ asset('storage/'.$product->image_path) }}"
                                                         class="w-full h-full object-cover {{ $isInactive ? 'grayscale opacity-50' : '' }}">
                                                @else
                                                    <div class="flex items-center justify-center h-full text-[9px] text-slate-600">No Img</div>
                                                @endif
                                            </div>

                                            <div class="min-w-0">
                                                <div class="text-white font-semibold text-xs truncate flex items-center gap-2">
                                                    {{ $product->name ?? 'Unknown Product' }}
                                                    @if($isInactive)
                                                        <span class="text-[8px] bg-red-500/20 text-red-400 px-1.5 rounded border border-red-500/30">DEACTIVATED</span>
                                                    @endif
                                                </div>
                                                <div class="text-[10px] text-indigo-400 font-mono">
                                                    {{ $order->order_number }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="text-center px-6 py-3">
                                        <span class="text-[10px] px-2 py-1 rounded-full
                                            @if($order->status=='Pending') bg-yellow-500/10 text-yellow-400
                                            @elseif($order->status=='Processing') bg-blue-500/10 text-blue-400
                                            @elseif($order->status=='Shipped') bg-indigo-500/10 text-indigo-400
                                            @elseif($order->status=='Delivered') bg-green-500/10 text-green-400
                                            @else bg-red-500/10 text-red-400 @endif">
                                            {{ $order->status }}
                                        </span>
                                    </td>

                                    <td class="text-right px-6 py-3 text-white font-bold text-xs">
                                        ₱{{ number_format($order->total_amount, 2) }}
                                    </td>

                                    <td class="text-right px-6 py-3">
                                        <button onclick="openModal(
                                            @js($product->name ?? 'Unknown Product'),
                                            @js($order->order_number),
                                            {{ $order->quantity }},
                                            {{ $order->total_amount }},
                                            @js($order->status),
                                            @js($product->image_path ?? null),
                                            @js($product->status ?? 'Active')
                                        )"
                                        class="bg-indigo-600 hover:bg-indigo-500 px-3 py-1 text-[10px] rounded-lg transition">
                                            View
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-16 text-slate-500 text-xs">
                                        No orders found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-white/5">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL --}}
    <div id="modal" class="hidden fixed inset-0 bg-black/70 flex items-center justify-center z-50">
        <div class="bg-[#0b0b10] w-[420px] p-6 rounded-xl border border-white/10">

            <div class="flex justify-center mb-4 relative">
                <div class="h-64 w-64 bg-black border border-white/10 rounded-xl overflow-hidden shadow-lg relative">
                    {{-- MODAL INACTIVE OVERLAY --}}
                    <div id="m_inactive_badge" class="hidden absolute inset-0 bg-red-900/60 z-10 flex flex-col items-center justify-center backdrop-blur-[1px]">
                        <span class="bg-red-600 text-white text-[10px] px-3 py-1 rounded-full font-black uppercase shadow-xl">Product Deactivated</span>
                    </div>
                    <img id="m_image" class="w-full h-full object-cover">
                </div>
            </div>

            <h2 id="m_name" class="text-white font-bold text-sm text-center"></h2>

            <div class="text-indigo-400 text-[11px] text-center mb-1">
                Order #: <span id="m_order"></span>
            </div>

            <div class="text-slate-400 text-[11px] text-center mb-1">
                Quantity: <span id="m_qty"></span>
            </div>

            <div class="text-slate-400 text-[11px] text-center mb-1">
                Status: <span id="m_status"></span>
            </div>

            <div class="text-white text-center font-bold mt-2">
                ₱<span id="m_total"></span>
            </div>

            <div class="flex justify-center mt-5">
                <button onclick="closeModal()"
                    class="bg-indigo-600 hover:bg-indigo-500 px-5 py-2 rounded-lg text-xs text-white font-bold">
                    Close
                </button>
            </div>
        </div>
    </div>

    <script>
        function openModal(name, order, qty, total, status, image, productStatus) {
            document.getElementById('modal').classList.remove('hidden');

            document.getElementById('m_name').innerText = name;
            document.getElementById('m_order').innerText = order;
            document.getElementById('m_qty').innerText = qty;
            document.getElementById('m_total').innerText = parseFloat(total).toFixed(2);
            document.getElementById('m_status').innerText = status;

            const img = document.getElementById('m_image');
            const inactiveBadge = document.getElementById('m_inactive_badge');
            
            img.src = image ? "/storage/" + image : "";

            if (productStatus === 'Inactive') {
                inactiveBadge.classList.remove('hidden');
                img.classList.add('grayscale', 'opacity-50');
            } else {
                inactiveBadge.classList.add('hidden');
                img.classList.remove('grayscale', 'opacity-50');
            }
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }
    </script>
</x-app-layout>