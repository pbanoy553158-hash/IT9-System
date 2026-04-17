<x-app-layout>
    <x-slot name="header">Transmission Pipeline</x-slot>

    <div class="space-y-8">
        <div class="flex justify-between items-center">
            <div>
                <h3 class="text-2xl font-black text-white tracking-tighter uppercase italic">Order Activity</h3>
                <p class="text-xs text-slate-500 uppercase tracking-[0.2em] font-bold mt-2">Real-Time Supplier Updates</p>
            </div>
            <div class="flex gap-3">
                <div class="px-4 py-2 bg-white/5 border border-white/10 rounded-xl flex items-center gap-3">
                    <span class="w-2 h-2 bg-indigo-500 rounded-full animate-ping"></span>
                    <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">System Live</span>
                </div>
            </div>
        </div>

        <div class="bg-[#020305] border border-white/5 rounded-[40px] overflow-hidden shadow-2xl">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/[0.02] border-b border-white/5">
                        <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Origin Node</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Transmission Ref</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Resource</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Value</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Current State</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Protocol Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($orders as $order)
                        <tr class="hover:bg-white/[0.01] transition-all group">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-[10px] font-bold text-indigo-400">
                                        {{ strtoupper(substr($order->user->name, 0, 2)) }}
                                    </div>
                                    <span class="text-sm font-bold text-white">{{ $order->user->name }}</span>
                                </div>
                            </td>

                            <td class="px-8 py-6">
                                <span class="text-xs font-mono font-bold text-slate-400 group-hover:text-indigo-400 transition-colors">
                                    {{ $order->order_number }}
                                </span>
                            </td>

                            <td class="px-8 py-6">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-slate-200">{{ $order->product_name }}</span>
                                    <span class="text-[10px] text-slate-500 uppercase font-black tracking-tighter mt-0.5">Quantity: {{ $order->quantity }}</span>
                                </div>
                            </td>

                            <td class="px-8 py-6">
                                <span class="text-sm font-black text-white italic">
                                    {{ $order->formatted_amount }}
                                </span>
                            </td>

                            <td class="px-8 py-6">
                                @php
                                    $colors = [
                                        'Pending'    => 'text-amber-500 bg-amber-500/10 border-amber-500/20',
                                        'Processing' => 'text-blue-400 bg-blue-400/10 border-blue-400/20',
                                        'Shipped'    => 'text-purple-400 bg-purple-400/10 border-purple-400/20',
                                        'Delivered'  => 'text-emerald-500 bg-emerald-500/10 border-emerald-500/20',
                                        'Rejected'   => 'text-red-500 bg-red-500/10 border-red-500/20',
                                    ];
                                    $statusStyle = $colors[$order->status] ?? 'text-slate-400 bg-slate-400/10 border-slate-400/20';
                                @endphp
                                <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest border {{ $statusStyle }}">
                                    ● {{ $order->status }}
                                </span>
                            </td>

                            <td class="px-8 py-6">
                                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" 
                                            class="bg-black border border-white/10 rounded-xl text-[10px] font-black uppercase tracking-widest text-slate-400 focus:border-indigo-500 focus:ring-0 transition-all py-1.5 pl-3 pr-8">
                                        <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Processing" {{ $order->status == 'Processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="Shipped" {{ $order->status == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                                        <option value="Delivered" {{ $order->status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                                        <option value="Rejected" {{ $order->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-8 py-24 text-center">
                                <span class="text-4xl block mb-4 opacity-20">📡</span>
                                <p class="text-slate-500 font-black uppercase tracking-[0.3em] text-xs">No order activities to show.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    </div>
</x-app-layout>