<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <span class="text-[#5046e5] font-bold text-xs tracking-widest uppercase">Analytics</span>
            <span class="h-4 w-[1px] bg-white/10"></span>
            <span class="text-white font-medium tracking-tight text-lg">Supplier Performance</span>
        </div>
    </x-slot>

    <style>
        .glass-card {
            background: linear-gradient(145deg, rgba(27, 25, 49, 0.4) 0%, rgba(13, 11, 26, 0.4) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .glass-card:hover {
            border-color: rgba(80, 70, 229, 0.3);
            transform: translateY(-2px);
        }
    </style>

    <div class="py-10 space-y-10 max-w-[1400px] mx-auto px-8">
        
        {{-- STATS GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 px-4">

            <div class="glass-card relative p-8 rounded-[2.2rem] shadow-2xl group overflow-hidden border border-white/5">
                <div class="absolute -top-12 -right-12 w-32 h-32 blur-[50px] opacity-20 bg-emerald-500 group-hover:opacity-30 transition-opacity"></div>
                
                <div class="relative z-10 flex justify-between items-center">
                    <div>
                        <p class="text-slate-500 text-[10px] font-bold uppercase tracking-[0.2em]">Platform Revenue</p>
                        <h3 class="text-3xl font-black text-white mt-3 tracking-tighter">
                            ₱{{ number_format($total_revenue, 2) }}
                        </h3>
                        <div class="flex items-center gap-2 mt-2">
                            <div class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse shadow-[0_0_8px_rgba(16,185,129,0.6)]"></div>
                            <p class="text-emerald-500 text-[10px] font-black uppercase tracking-widest">Net Delivered</p>
                        </div>
                    </div>
                    <div class="text-[#5046e5] font-black text-3xl italic pr-2">₱</div>
                </div>
            </div>

            <div class="glass-card relative p-8 rounded-[2.2rem] shadow-2xl group overflow-hidden border border-white/5">
                <div class="absolute -top-12 -right-12 w-32 h-32 blur-[50px] opacity-20 bg-[#5046e5] group-hover:opacity-30 transition-opacity"></div>

                <div class="relative z-10 flex justify-between items-center">
                    <div>
                        <p class="text-slate-500 text-[10px] font-bold uppercase tracking-[0.2em]">Active Suppliers</p>
                        <h3 class="text-3xl font-black text-white mt-3 tracking-tighter">
                            {{ number_format($supplier_count) }}
                        </h3>
                        <p class="text-slate-400 text-[10px] mt-2 font-bold uppercase tracking-widest">Partner Nodes</p>
                    </div>
                    <div class="text-white/20 group-hover:text-[#5046e5] transition-colors pr-1">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-[#5046e5] p-8 rounded-[2.2rem] shadow-2xl shadow-indigo-500/20 flex items-center justify-between transition-transform hover:scale-[1.01]">
                <div>
                    <p class="text-white/70 text-[10px] font-bold uppercase tracking-[0.2em]">Total Orders</p>
                    <h3 class="text-3xl font-black text-white mt-3 tracking-tighter">
                        {{ number_format($total_orders) }}
                    </h3>
                    <p class="text-white/60 text-[10px] mt-2 font-medium uppercase tracking-widest italic">Lifetime Sync</p>
                </div>
                <div class="text-white/40 pr-1">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- PERFORMANCE TABLE CARD --}}
        <div class="glass-card rounded-[2.5rem] overflow-hidden mx-4 border border-white/5">
            <div class="px-8 py-6 border-b border-white/5 flex justify-between items-center bg-white/[0.01]">
                <div>

                    <h4 class="text-white font-semibold text-xl tracking-tight">Performance Matrix</h4>
                    <p class="text-slate-400 text-sm mt-1 italic font-medium">Revenue contribution by partner networks</p>
                </div>
                <div class="px-3 py-1 text-[9px] font-black text-[#818cf8] bg-[#5046e5]/10 border border-[#5046e5]/20 rounded uppercase tracking-[0.2em]">
                    Live data relay
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-xs text-slate-500 border-b border-white/5 font-medium">
                            <th class="px-8 py-5">Rank</th>
                            <th class="px-8 py-5">Supplier</th>
                            <th class="px-8 py-5 text-center">Orders</th>
                            <th class="px-8 py-5">Revenue</th>
                            <th class="px-8 py-5 text-right">Market share</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-white/5">
                        @forelse(collect($supplier_performance)->sortByDesc('revenue')->values() as $index => $item)

                        @php
                            $share = $total_revenue > 0 
                                ? ($item['revenue'] / $total_revenue) * 100 
                                : 0;
                        @endphp

                        <tr class="hover:bg-white/[0.02] transition-colors group">
                            <td class="px-8 py-6 text-xs text-slate-500 font-bold tracking-widest">
                                #{{ $index + 1 }}
                            </td>

                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-[#0d0b1a] border border-white/5 flex items-center justify-center text-[#5046e5] font-black text-xs group-hover:border-[#5046e5]/30 transition-all">
                                        {{ strtoupper(substr($item['name'], 0, 1)) }}
                                    </div>
                                    <span class="text-sm font-semibold text-white group-hover:text-[#5046e5] transition-colors tracking-tight">
                                        {{ $item['name'] }}
                                    </span>
                                </div>
                            </td>

                            <td class="px-8 py-6 text-center text-sm text-slate-400 font-medium tracking-tighter">
                                {{ number_format($item['orders']) }}
                            </td>

                            <td class="px-8 py-6">
                                <span class="text-emerald-400 font-semibold text-sm tracking-tighter">
                                    ₱{{ number_format($item['revenue'], 2) }}
                                </span>
                            </td>

                            <td class="px-8 py-6 text-right w-[240px]">
                                <div class="flex flex-col items-end gap-2">
                                    <span class="text-[10px] text-[#818cf8] font-bold uppercase tracking-widest">
                                        {{ round($share, 1) }}% Share
                                    </span>
                                    <div class="w-full h-1.5 bg-white/5 rounded-full overflow-hidden border border-white/5">
                                        <div class="h-full bg-[#5046e5] rounded-full transition-all duration-700 shadow-[0_0_10px_rgba(80,70,229,0.4)]"
                                             style="width: {{ $share }}%">
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="5" class="py-24 text-center">
                                <span class="text-slate-600 text-[11px] italic font-medium">No active supplier data stream available</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout> 