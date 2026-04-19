<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <span class="text-[#5046e5] font-semibold text-xs tracking-widest uppercase">Hub</span>
            <span class="h-4 w-[1px] bg-white/10"></span>
            <span class="text-white font-medium tracking-tight">Supplier Dashboard</span>
        </div>
    </x-slot>

    <div class="py-6 space-y-5 font-['Inter'] antialiased max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">

            {{-- Main Stats Card --}}
            <div class="lg:col-span-8 bg-[#1e1b2e] border border-white/10 rounded-[2rem] p-6 shadow-xl relative overflow-hidden group">
                <div class="absolute -right-16 -top-16 w-40 h-40 bg-indigo-500/5 rounded-full blur-3xl group-hover:bg-indigo-500/10 transition-all duration-700"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-bold text-white tracking-tight">Supplier Orders</h2>
                        <p class="text-slate-500 text-xs font-medium mt-0.5">Track and manage purchase requisitions.</p>
                        
                        <div class="flex items-end gap-3 mt-4">
                            <h1 class="text-5xl font-extrabold text-white tracking-tighter leading-none">
                                {{ $stats['total'] }}
                            </h1>
                            <div class="pb-1">
                                <span class="text-indigo-400 text-[10px] font-black uppercase tracking-widest">Active Units</span>
                            </div>
                        </div>
                    </div>

                    <div class="px-4 py-2 bg-emerald-500/5 border border-emerald-500/10 rounded-xl flex items-center gap-2.5 self-start md:self-center">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        <span class="text-[10px] font-black text-emerald-400 uppercase tracking-widest">Live Pipeline</span>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4 mt-6 pt-6 border-t border-white/5">
                    <div>
                        <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest">Pending</p>
                        <p class="text-white text-xl font-bold mt-0.5 tracking-tight">{{ $stats['pending'] }}</p>
                    </div>
                    <div class="border-l border-white/5 pl-4">
                        <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest">In Transit</p>
                        <p class="text-white text-xl font-bold mt-0.5 tracking-tight">{{ $stats['shipped'] }}</p>
                    </div>
                    <div class="border-l border-white/5 pl-4">
                        <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest">Delivered</p>
                        <p class="text-white text-xl font-bold mt-0.5 tracking-tight">{{ $stats['delivered'] }}</p>
                    </div>
                </div>
            </div>

            {{-- Action Card --}}
            <div class="lg:col-span-4 bg-gradient-to-br from-indigo-600 to-indigo-700 rounded-[2rem] p-6 shadow-2xl flex flex-col justify-between border border-white/10 relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="text-xl font-bold text-white tracking-tight leading-tight">New Order Requisition</h3>
                    <p class="mt-2 text-indigo-100/70 text-xs leading-relaxed font-medium">
                        Log a new supply request into the central administration pipeline.
                    </p>
                </div>
                <a href="{{ route('supplier.orders.create') }}" 
                   class="mt-6 flex items-center justify-center gap-2 px-5 py-3.5 bg-white text-indigo-900 font-bold text-[10px] uppercase tracking-widest rounded-xl hover:bg-indigo-50 hover:scale-[1.02] transition-all duration-300 shadow-lg">
                    Create Entry
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
            
            {{-- Activity Table --}}
            <div class="lg:col-span-8 bg-[#1e1b2e] border border-white/10 rounded-[2rem] overflow-hidden shadow-xl">
                <div class="px-6 py-4 border-b border-white/5 flex justify-between items-center bg-white/[0.01]">
                    <h3 class="text-white font-bold text-sm tracking-tight">Recent Activity</h3>
                    <a href="{{ route('supplier.orders.index') }}" class="text-indigo-400 text-[10px] font-black hover:text-white transition-all uppercase tracking-widest">View All</a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-slate-500 text-[10px] font-bold uppercase tracking-widest border-b border-white/5">
                                <th class="px-6 py-3">Item Details</th>
                                <th class="px-6 py-3 text-center">Status</th>
                                <th class="px-6 py-3 text-right">Value</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($recent_orders as $order)
                            <tr class="group hover:bg-white/[0.02] transition-all">
                                <td class="px-6 py-3.5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-indigo-500/10 border border-indigo-500/10 flex items-center justify-center text-indigo-400 font-mono text-[10px] font-bold">
                                            #{{ substr($order->order_number, -4) }}
                                        </div>
                                        <div>
                                            <p class="text-white text-sm font-bold tracking-tight">{{ $order->product_name }}</p>
                                            <p class="text-slate-500 text-[10px] font-medium">{{ $order->created_at->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-3.5 text-center">
                                    @php
                                        $statusColor = match($order->status) {
                                            'Pending' => 'amber',
                                            'Delivered' => 'emerald',
                                            'Shipped' => 'indigo',
                                            default => 'slate',
                                        };
                                    @endphp
                                    <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest border border-{{ $statusColor }}-500/20 bg-{{ $statusColor }}-500/5 text-{{ $statusColor }}-500">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-3.5 text-right">
                                    <p class="text-white text-sm font-bold tracking-tighter">{{ $order->formatted_amount }}</p>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="py-12 text-center text-slate-600 text-xs italic">No recent activity detected.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Sidebar Actions --}}
            <div class="lg:col-span-4 space-y-3">
                <div class="bg-[#1e1b2e] border border-white/10 rounded-2xl p-4 hover:bg-[#25223a] transition-all cursor-pointer group flex items-center gap-4 shadow-lg border-l-4 border-l-indigo-500">
                    <div class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center text-base group-hover:bg-indigo-600 transition-all duration-500">
                        📄
                    </div>
                    <div>
                        <p class="text-white font-bold text-xs tracking-tight">Manifest Archives</p>
                        <p class="text-slate-500 text-[10px] font-medium">Invoice exports</p>
                    </div>
                </div>

                <div class="bg-white/[0.02] border border-white/5 rounded-2xl p-4 hover:bg-white/[0.05] transition-all cursor-pointer group flex items-center gap-4">
                    <div class="w-10 h-10 bg-indigo-500/10 rounded-xl flex items-center justify-center text-base">
                        🎧
                    </div>
                    <div>
                        <p class="text-slate-300 font-bold text-xs tracking-tight">Admin Support</p>
                        <p class="text-slate-500 text-[10px] font-medium">Direct helpdesk</p>
                    </div>
                </div>

                <div class="bg-indigo-600/5 border border-indigo-500/10 rounded-2xl p-5 mt-2">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-1 h-1 rounded-full bg-indigo-500"></div>
                        <p class="text-indigo-400 text-[9px] font-black uppercase tracking-[0.2em]">Notice</p>
                    </div>
                    <p class="text-slate-500 text-[11px] leading-relaxed font-medium">
                        Order metrics update in real-time. For discrepancies, contact hub administration.
                    </p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>