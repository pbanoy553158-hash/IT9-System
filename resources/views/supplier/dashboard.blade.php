<x-app-layout>
    <x-slot name="header">Supplier Dashboard</x-slot>

    <div class="space-y-6 font-['Inter'] antialiased">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <div class="lg:col-span-8 bg-[#1e1b2e] border border-white/10 rounded-3xl p-8 shadow-xl relative overflow-hidden group">
                <div class="absolute -right-16 -top-16 w-48 h-48 bg-indigo-500/5 rounded-full blur-3xl group-hover:bg-indigo-500/10 transition-all duration-700"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <h2 class="text-2xl font-bold text-white tracking-tight">Supplier Orders</h2>
                        <p class="text-slate-400 text-sm font-medium mt-1">Track and manage purchase requisitions.</p>
                        
                        <div class="flex items-end gap-3 mt-6">
                            <h1 class="text-6xl font-extrabold text-white tracking-tighter leading-none">
                                {{ $stats['total'] }}
                            </h1>
                            <div class="pb-1">
                                <span class="text-indigo-400 text-xs font-bold uppercase tracking-widest">Active Units</span>
                            </div>
                        </div>
                    </div>

                    <div class="px-5 py-3 bg-emerald-500/5 border border-emerald-500/10 rounded-xl flex items-center gap-3 self-start md:self-center">
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                        </span>
                        <span class="text-[11px] font-black text-emerald-400 uppercase tracking-widest text-nowrap">Live Pipeline</span>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-6 mt-8 pt-8 border-t border-white/5 text-center md:text-left">
                    <div>
                        <p class="text-slate-500 text-[11px] font-bold uppercase tracking-widest">Pending</p>
                        <p class="text-white text-2xl font-bold mt-1 tracking-tight">{{ $stats['pending'] }}</p>
                    </div>
                    <div>
                        <p class="text-slate-500 text-[11px] font-bold uppercase tracking-widest">In Transit</p>
                        <p class="text-white text-2xl font-bold mt-1 tracking-tight">{{ $stats['shipped'] }}</p>
                    </div>
                    <div>
                        <p class="text-slate-500 text-[11px] font-bold uppercase tracking-widest">Delivered</p>
                        <p class="text-white text-2xl font-bold mt-1 tracking-tight">{{ $stats['delivered'] }}</p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-4 bg-gradient-to-br from-indigo-600 to-indigo-700 rounded-3xl p-8 shadow-2xl flex flex-col justify-between border border-white/10 group">
                <div>
                    <h3 class="text-2xl font-bold text-white tracking-tight leading-tight">New Order Requisition</h3>
                    <p class="mt-3 text-indigo-100/80 text-sm leading-relaxed font-medium">
                        Log a new supply request into the central administration pipeline.
                    </p>
                </div>
                <a href="{{ route('supplier.orders.create') }}" 
                   class="mt-6 flex items-center justify-center gap-3 px-6 py-5 bg-white text-indigo-900 font-bold text-xs uppercase tracking-widest rounded-xl hover:bg-indigo-50 hover:scale-[1.01] transition-all duration-300 shadow-lg">
                    Create Entry
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            <div class="lg:col-span-8 bg-[#1e1b2e] border border-white/10 rounded-3xl overflow-hidden shadow-xl">
                <div class="px-8 py-6 border-b border-white/5 flex justify-between items-center bg-white/[0.01]">
                    <h3 class="text-white font-bold text-lg tracking-tight">Recent Activity</h3>
                    <a href="{{ route('supplier.orders.index') }}" class="text-indigo-400 text-xs font-bold hover:text-white transition-all uppercase tracking-wider">View All</a>
                </div>
                
                <div class="overflow-x-auto px-8 pb-6">
                    <table class="w-full text-left border-separate border-spacing-y-4">
                        <thead>
                            <tr class="text-slate-500 text-[11px] font-bold uppercase tracking-widest">
                                <th class="px-4 py-2">Item Details</th>
                                <th class="px-4 py-2 text-center">Status</th>
                                <th class="px-4 py-2 text-right">Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_orders as $order)
                            <tr class="group transition-all">
                                <td class="px-5 py-4 bg-white/[0.02] rounded-l-2xl border-y border-l border-white/5 group-hover:bg-white/[0.04]">
                                    <div class="flex items-center gap-5">
                                        <div class="w-12 h-12 rounded-xl bg-indigo-500/10 border border-indigo-500/10 flex items-center justify-center text-indigo-400 font-mono text-xs font-bold">
                                            #{{ substr($order->order_number, -4) }}
                                        </div>
                                        <div>
                                            <p class="text-white text-base font-bold tracking-tight">{{ $order->product_name }}</p>
                                            <p class="text-slate-500 text-xs font-medium mt-0.5">{{ $order->created_at->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4 bg-white/[0.02] border-y border-white/5 group-hover:bg-white/[0.04] text-center">
                                    @php
                                        $statusColor = match($order->status) {
                                            'Pending' => 'amber',
                                            'Delivered' => 'emerald',
                                            'Shipped' => 'indigo',
                                            default => 'slate',
                                        };
                                    @endphp
                                    <span class="px-4 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest border border-{{ $statusColor }}-500/20 bg-{{ $statusColor }}-500/5 text-{{ $statusColor }}-500">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 bg-white/[0.02] rounded-r-2xl border-y border-r border-white/5 group-hover:bg-white/[0.04] text-right">
                                    <p class="text-white text-base font-bold tracking-tighter">{{ $order->formatted_amount }}</p>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="py-16 text-center opacity-40 text-sm italic">No recent activity found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="lg:col-span-4 space-y-4">
                <div class="bg-[#1e1b2e] border border-white/10 rounded-2xl p-5 hover:bg-[#25223a] transition-all cursor-pointer group flex items-center gap-5 shadow-lg">
                    <div class="w-12 h-12 bg-white/5 rounded-xl flex items-center justify-center text-xl group-hover:bg-indigo-600 transition-all duration-500">
                        📄
                    </div>
                    <div>
                        <p class="text-white font-bold text-sm tracking-tight">Manifest Archives</p>
                        <p class="text-slate-500 text-xs mt-1 font-medium">Invoice exports</p>
                    </div>
                </div>

                <div class="bg-white/[0.02] border border-white/5 rounded-2xl p-5 hover:bg-white/[0.05] transition-all cursor-pointer group flex items-center gap-5">
                    <div class="w-12 h-12 bg-indigo-500/10 rounded-xl flex items-center justify-center text-lg">
                        🎧
                    </div>
                    <div>
                        <p class="text-slate-300 font-bold text-sm tracking-tight">Admin Support</p>
                        <p class="text-slate-500 text-xs mt-1 font-medium">Direct helpdesk</p>
                    </div>
                </div>

                <div class="bg-indigo-600/5 border border-indigo-500/10 rounded-2xl p-6 mt-2">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-1.5 h-1.5 rounded-full bg-indigo-500"></div>
                        <p class="text-indigo-400 text-[11px] font-black uppercase tracking-widest">Notice</p>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed font-medium">
                        Order metrics are updated in real-time. For urgent changes or discrepancies, contact the hub administration immediately.
                    </p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>