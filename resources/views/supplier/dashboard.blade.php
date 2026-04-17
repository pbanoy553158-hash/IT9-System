<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <span class="text-indigo-400 text-2xl">📦</span>
            <span class="font-black tracking-tighter text-white uppercase italic">Supplier Control Node</span>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <div class="lg:col-span-7">
            <div class="relative group bg-[#0d0f14] p-12 rounded-[48px] border border-white/5 shadow-2xl overflow-hidden min-h-[400px] flex flex-col justify-between">
                <div class="absolute -top-24 -left-24 w-96 h-96 bg-indigo-600/10 rounded-full blur-[100px] group-hover:bg-indigo-600/20 transition-all duration-700"></div>
                
                <div class="relative z-10">
                    <p class="text-slate-500 text-xs font-black uppercase tracking-[0.4em] mb-2">Total Active Transmissions</p>
                    <div class="flex items-baseline gap-6">
                        <h3 class="text-[10rem] font-black text-white leading-none tracking-tighter drop-shadow-2xl">
                            {{ \App\Models\Order::where('user_id', Auth::id())->count() }}
                        </h3>
                        <div class="flex flex-col">
                            <span class="text-indigo-400 font-black italic text-xl tracking-widest uppercase">Nodes</span>
                            <span class="text-emerald-500 font-bold text-xs uppercase tracking-widest">● Synchronized</span>
                        </div>
                    </div>
                </div>

                <div class="relative z-10 grid grid-cols-3 gap-8 pt-10 border-t border-white/5">
                    <div>
                        <p class="text-slate-500 text-[10px] font-black uppercase tracking-widest mb-1">Queue Status</p>
                        <p class="text-white font-bold text-lg tabular-nums tracking-tight">Optimal</p>
                    </div>
                    <div>
                        <p class="text-slate-500 text-[10px] font-black uppercase tracking-widest mb-1">Last Sync</p>
                        <p class="text-white font-bold text-lg tabular-nums tracking-tight">Just Now</p>
                    </div>
                    <div>
                        <p class="text-slate-500 text-[10px] font-black uppercase tracking-widest mb-1">Node Uplink</p>
                        <p class="text-emerald-500 font-bold text-lg tabular-nums tracking-tight">Encrypted</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-5 flex flex-col gap-6">
            <div class="bg-gradient-to-br from-indigo-600 to-purple-800 p-10 rounded-[48px] shadow-2xl shadow-indigo-500/20 group relative overflow-hidden flex-1 flex flex-col justify-center">
                <div class="relative z-10 text-white">
                    <h3 class="text-4xl font-black italic uppercase leading-none tracking-tighter">Initiate <br>New Order</h3>
                    <p class="text-indigo-100 text-sm mt-4 opacity-80 max-w-[280px] font-medium leading-relaxed">
                        Authorize a new shipment transmission to the master distribution center.
                    </p>
                    
                    <a href="{{ route('supplier.orders.index') }}" class="mt-8 inline-flex items-center gap-3 px-10 py-5 bg-white text-indigo-900 font-black rounded-2xl hover:scale-105 hover:shadow-2xl transition-all duration-300 uppercase tracking-widest text-xs">
                        Start Process 
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
                <div class="absolute -bottom-10 -right-10 text-[18rem] opacity-10 group-hover:rotate-6 transition-transform duration-700 pointer-events-none">📦</div>
            </div>

            <div class="bg-[#161922] border border-white/5 p-8 rounded-[40px] flex items-center justify-between hover:bg-white/[0.03] transition cursor-pointer group">
                <div class="flex items-center gap-5">
                    <div class="w-14 h-14 bg-white/5 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">📄</div>
                    <div>
                        <p class="text-white font-bold tracking-tight">Manifest Archives</p>
                        <p class="text-slate-500 text-xs font-medium">Download previous invoice logs</p>
                    </div>
                </div>
                <div class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center text-slate-500 group-hover:text-white group-hover:border-white transition">→</div>
            </div>
        </div>
    </div>
</x-app-layout>