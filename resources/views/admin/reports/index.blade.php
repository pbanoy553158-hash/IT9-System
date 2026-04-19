<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <span class="text-[#5046e5] font-semibold text-[10px] tracking-[0.2em] uppercase">Analytics</span>
            <span class="h-3 w-[1px] bg-white/10"></span>
            <span class="text-white text-sm font-medium tracking-tight">Market Intelligence</span>
        </div>
    </x-slot>

    <div class="py-6 space-y-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- STATS GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

            {{-- Revenue Card --}}
            <div class="bg-[#1b1931]/40 border border-white/5 p-6 rounded-[2rem] shadow-2xl relative overflow-hidden flex items-center justify-between">
                <div class="absolute inset-0 bg-gradient-to-br from-[#5046e5]/5 to-transparent pointer-events-none"></div>
                <div class="relative z-10">
                    <p class="text-slate-500 text-[9px] font-bold uppercase tracking-[0.2em]">Platform Revenue</p>
                    <h3 class="text-2xl font-semibold text-white mt-2 tracking-tighter">
                        ₱{{ number_format($total_revenue, 2) }}
                    </h3>
                    <div class="flex items-center gap-2 mt-2">
                        <div class="w-1 h-1 bg-emerald-500 rounded-full animate-pulse shadow-[0_0_8px_rgba(16,185,129,0.6)]"></div>
                        <p class="text-emerald-500 text-[9px] font-black uppercase tracking-wider">Net Delivered</p>
                    </div>
                </div>
                <div class="w-12 h-12 bg-[#0d0b1a] border border-white/5 rounded-xl flex items-center justify-center relative z-10 shadow-inner">
                    <span class="text-[#5046e5] font-black text-lg italic">₱</span>
                </div>
            </div>

            {{-- Suppliers Card --}}
            <div class="bg-[#1b1931]/40 border border-white/5 p-6 rounded-[2rem] shadow-2xl relative overflow-hidden flex items-center justify-between">
                <div class="relative z-10">
                    <p class="text-slate-500 text-[9px] font-bold uppercase tracking-[0.2em]">Active Suppliers</p>
                    <h3 class="text-2xl font-semibold text-white mt-2 tracking-tighter">
                        {{ $supplier_count }}
                    </h3>
                    <p class="text-slate-400 text-[9px] mt-2 font-medium uppercase tracking-widest">Partner Nodes</p>
                </div>
                <div class="w-12 h-12 bg-[#0d0b1a] border border-white/5 rounded-xl flex items-center justify-center relative z-10 shadow-inner">
                    <svg class="w-5 h-5 text-[#5046e5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                </div>
            </div>

            {{-- Transactions Card (Violet Accent) --}}
            <div class="bg-[#5046e5] p-6 rounded-[2rem] shadow-2xl shadow-indigo-500/20 flex items-center justify-between transition-transform hover:scale-[1.01]">
                <div>
                    <p class="text-white/70 text-[9px] font-bold uppercase tracking-[0.2em]">Total Traffic</p>
                    <h3 class="text-2xl font-bold text-white mt-2 tracking-tighter">
                        {{ number_format($total_orders) }}
                    </h3>
                    <p class="text-white/60 text-[9px] mt-2 font-medium uppercase tracking-widest italic">Lifetime Sync</p>
                </div>
                <div class="w-12 h-12 bg-white/10 border border-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                </div>
            </div>
        </div>

        {{-- COMPACT PERFORMANCE TABLE --}}
        <div class="bg-[#1b1931] border border-white/10 rounded-[1.5rem] shadow-2xl overflow-hidden">
            <div class="px-6 py-4 border-b border-white/5 flex items-center justify-between bg-white/[0.02]">
                <div>
                    <h4 class="text-white font-semibold text-base tracking-tight">Performance Matrix</h4>
                    <p class="text-slate-500 text-[10px] mt-0.5">Revenue contribution by partner networks.</p>
                </div>
                <div class="px-3 py-1 bg-[#5046e5]/10 text-[8px] font-black text-[#818cf8] rounded border border-[#5046e5]/20 uppercase tracking-[0.2em]">
                    Live Relay
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[9px] font-bold uppercase tracking-[0.2em] text-slate-500 border-b border-white/5 bg-white/[0.01]">
                            <th class="px-6 py-3">Supplier Name</th>
                            <th class="px-6 py-3 text-center">Orders</th>
                            <th class="px-6 py-3">Value Generation</th>
                            <th class="px-6 py-3 text-right">Share Index</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($supplier_performance as $item)
                        <tr class="hover:bg-white/[0.01] transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-[#0d0b1a] border border-[#5046e5]/20 flex items-center justify-center text-[#818cf8] font-bold text-[10px]">
                                        {{ strtoupper(substr($item['name'], 0, 1)) }}
                                    </div>
                                    <span class="text-xs font-semibold text-white group-hover:text-[#5046e5] transition-colors">{{ $item['name'] }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center font-mono text-[11px] font-bold text-slate-400">
                                {{ number_format($item['orders']) }}
                            </td>
                            <td class="px-6 py-4 font-mono text-emerald-400 font-bold text-xs tracking-tighter">
                                ₱{{ number_format($item['revenue'], 2) }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="inline-flex items-center px-3 py-1 text-[8px] font-black bg-[#5046e5]/5 text-[#818cf8] border border-[#5046e5]/10 rounded-lg uppercase tracking-widest">
                                    {{ $total_revenue > 0 ? round(($item['revenue'] / $total_revenue) * 100, 1) : 0 }}%
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-slate-600 text-[10px] uppercase tracking-widest font-black">
                                No performance data detected
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>