    <x-app-layout>
        <x-slot name="header">
            <div class="flex items-center gap-3">
                <span class="text-[#5046e5] font-bold text-xs tracking-widest uppercase">Reports</span>
                <span class="h-4 w-[1px] bg-white/10"></span>
                <span class="text-white font-medium tracking-tight text-lg">Overview Dashboard</span>
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

            {{-- GRID --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 px-4">

                {{-- CARD 1 --}}
                <div class="glass-card relative p-8 rounded-[2.2rem] shadow-2xl group overflow-hidden border border-white/5">
                    <div class="absolute -top-12 -right-12 w-32 h-32 blur-[50px] opacity-20 bg-emerald-500 group-hover:opacity-30"></div>

                    <div class="relative z-10 space-y-6">

                        {{-- LABEL --}}
                        <p class="text-slate-500 text-[10px] font-bold uppercase tracking-[0.2em]">
                            Platform Revenue
                        </p>

                        {{-- ICON + VALUE --}}
                        <div class="flex items-start justify-between">

                            {{-- ICON LEFT --}}
                            <div class="text-[#5046e5] font-black text-3xl italic">
                                ₱
                            </div>

                            {{-- VALUE RIGHT --}}
                            <div class="text-right">
                                <h3 class="text-3xl font-black text-white tracking-tighter">
                                    ₱{{ number_format($total_revenue, 2) }}
                                </h3>
                                <p class="text-emerald-500 text-[10px] font-black uppercase tracking-widest mt-1 flex items-center justify-end gap-2">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                                    Net Delivered
                                </p>
                            </div>

                        </div>

                    </div>
                </div>

                {{-- CARD 2 --}}
                <div class="glass-card relative p-8 rounded-[2.2rem] shadow-2xl group overflow-hidden border border-white/5">
                    <div class="absolute -top-12 -right-12 w-32 h-32 blur-[50px] opacity-20 bg-[#5046e5] group-hover:opacity-30"></div>

                    <div class="relative z-10 space-y-6">

                        {{-- LABEL --}}
                        <p class="text-slate-500 text-[10px] font-bold uppercase tracking-[0.2em]">
                            Active Suppliers
                        </p>

                        {{-- ICON + VALUE --}}
                        <div class="flex items-start justify-between">

                            {{-- ICON LEFT --}}
                            <div class="text-white/20 group-hover:text-[#5046e5] transition-colors">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>

                            {{-- VALUE RIGHT --}}
                            <div class="text-right">
                                <h3 class="text-3xl font-black text-white tracking-tighter">
                                    {{ number_format($supplier_count) }}
                                </h3>
                                <p class="text-slate-400 text-[10px] mt-1 font-bold uppercase tracking-widest">
                                    Partner Nodes
                                </p>
                            </div>

                        </div>

                    </div>
                </div>

                {{-- CARD 3 --}}
                <div class="bg-[#5046e5] p-8 rounded-[2.2rem] shadow-2xl shadow-indigo-500/20">

                    <div class="space-y-6">

                        {{-- LABEL --}}
                        <p class="text-white/70 text-[10px] font-bold uppercase tracking-[0.2em]">
                            Total Orders
                        </p>

                        {{-- ICON + VALUE --}}
                        <div class="flex items-start justify-between">

                            {{-- ICON LEFT --}}
                            <div class="text-white/40">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>

                            {{-- VALUE RIGHT --}}
                            <div class="text-right">
                                <h3 class="text-3xl font-black text-white tracking-tighter">
                                    {{ number_format($total_orders) }}
                                </h3>
                                <p class="text-white/60 text-[10px] mt-1 font-medium uppercase tracking-widest italic">
                                    Lifetime Sync
                                </p>
                            </div>

                        </div>

                    </div>
                </div>

            </div>

            {{-- NAVIGATION (UNCHANGED) --}}
            <div class="glass-card rounded-[2.5rem] overflow-hidden mx-4 border border-white/5">
                <div class="px-8 py-6 border-b border-white/5 flex items-center justify-between bg-white/[0.01]">
                    <div>
                        <h4 class="text-white font-semibold text-xl tracking-tight">Reports Navigation</h4>
                        <p class="text-slate-400 text-sm mt-1 italic font-medium">Access detailed analytics modules</p>
                    </div>
                </div>

                <div class="p-8">
                    <a href="{{ route('admin.reports.supplier-performance') }}"
                    class="inline-flex items-center gap-2.5 px-6 py-3 bg-[#5046e5] text-white text-[12px] font-semibold rounded-xl">
                        Supplier Performance Analysis
                    </a>
                </div>
            </div>

        </div>
    </x-app-layout>