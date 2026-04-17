<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-[0.3em]">
            <span class="text-slate-500">Infrastructure</span>
            <span class="text-slate-700">/</span>
            <span class="text-indigo-400">Node Management</span>
        </div>
    </x-slot>

    <div x-data="{ openAddModal: false }" class="min-h-screen py-12 px-6 bg-[#050505] relative overflow-hidden">
        
        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-indigo-600/5 blur-[120px] rounded-full"></div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-slate-800/10 blur-[100px] rounded-full"></div>

        <div class="max-w-7xl mx-auto relative z-10 space-y-10">
            
            <div class="flex flex-col md:flex-row justify-between items-end border-b border-white/5 pb-10 gap-6">
                <div>
                    <h2 class="text-4xl font-black italic text-white tracking-tighter uppercase leading-none">
                        PARTNER <span class="text-indigo-500 not-italic font-light">REGISTRY</span>
                    </h2>
                    <div class="flex items-center gap-2 mt-4">
                        <div class="w-1.5 h-1.5 rounded-full bg-indigo-500 shadow-[0_0_10px_#6366f1]"></div>
                        <p class="text-[9px] font-bold text-slate-500 uppercase tracking-[0.4em]">
                            Verified Network: {{ $suppliers->count() }} Authorized Nodes
                        </p>
                    </div>
                </div>
                
                <button @click="openAddModal = true"
                    class="px-8 py-4 bg-white text-black hover:bg-slate-200 rounded-full font-bold text-[10px] uppercase tracking-[0.2em] transition-all shadow-[0_10px_40px_rgba(255,255,255,0.1)] active:scale-95 flex items-center gap-3">
                    <span>Register Supplier</span>
                </button>
            </div>

            @if(session('success'))
                <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl">
                    <p class="text-emerald-500 text-[9px] font-bold uppercase tracking-[0.3em] text-center">
                        {{ session('success') }}
                    </p>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($suppliers as $supplier)
                    <div class="group relative bg-[#0d0f14]/60 backdrop-blur-md border border-white/[0.05] rounded-[24px] p-6 hover:bg-[#11141b] hover:border-indigo-500/40 transition-all duration-500 shadow-2xl">
                        
                        <div class="flex justify-between items-center mb-6">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-white/[0.08] to-transparent border border-white/10 flex items-center justify-center text-lg group-hover:scale-110 transition-transform duration-500">
                                🏢
                            </div>
                            <div class="flex items-center gap-1.5 px-2 py-1 rounded-full bg-emerald-500/5 border border-emerald-500/10">
                                <div class="w-1 h-1 bg-emerald-500 rounded-full shadow-[0_0_5px_#10b981]"></div>
                                <span class="text-[8px] font-black text-emerald-500 uppercase tracking-tighter">Active</span>
                            </div>
                        </div>

                        <div class="space-y-1 mb-6">
                            <h4 class="text-white font-bold text-base tracking-tight truncate uppercase group-hover:text-indigo-400 transition-colors">
                                {{ $supplier->name }}
                            </h4>
                            <p class="text-[9px] text-slate-600 font-bold truncate tracking-[0.1em] uppercase opacity-70">
                                {{ $supplier->email }}
                            </p>
                        </div>

                        <div class="grid grid-cols-2 gap-4 py-4 border-y border-white/[0.03]">
                            <div>
                                <p class="text-[8px] text-slate-500 font-bold uppercase tracking-widest mb-1">Traffic</p>
                                <p class="text-xs text-slate-200 font-mono italic">{{ $supplier->orders_count }} Units</p>
                            </div>
                            <div class="text-right">
                                <p class="text-[8px] text-slate-500 font-bold uppercase tracking-widest mb-1">Created</p>
                                <p class="text-xs text-slate-400 font-mono">{{ $supplier->created_at->format('d.m.y') }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 mt-6">
                            <button class="flex-1 py-2.5 rounded-lg bg-white/5 hover:bg-white/10 border border-white/10 text-[9px] font-bold text-slate-400 hover:text-white uppercase tracking-[0.2em] transition-all">
                                Access Logs
                            </button>
                            
                            <form action="{{ route('admin.suppliers.destroy', $supplier->id) }}" method="POST" onsubmit="return confirm('Confirm deactivation?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-10 h-10 flex items-center justify-center rounded-lg bg-red-500/5 hover:bg-red-500/20 border border-red-500/10 text-red-500/30 hover:text-red-500 transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>

                        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-1/2 h-[1px] bg-gradient-to-r from-transparent via-indigo-500/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                    </div>
                @empty
                    <div class="col-span-full py-32 bg-[#0a0c12]/30 border border-dashed border-white/5 rounded-[40px] flex flex-col items-center justify-center text-center">
                        <p class="text-slate-700 font-bold uppercase tracking-[0.5em] text-[10px]">Registry Empty / Offline</p>
                    </div>
                @endforelse
            </div>

            <div x-show="openAddModal"
                 class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-black/95 backdrop-blur-2xl"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 style="display: none;">

                <div @click.away="openAddModal = false"
                     class="bg-[#0d0f14] border border-white/10 w-full max-w-xl rounded-[40px] shadow-[0_0_100px_-20px_rgba(99,102,241,0.3)] overflow-hidden">

                    <div class="p-12 md:p-16">
                        <div class="mb-12">
                            <h2 class="text-3xl font-black italic text-white tracking-tighter uppercase leading-none">
                                NEW RESOURCE <span class="text-indigo-500 not-italic font-light">NODE</span>
                            </h2>
                            <p class="text-[9px] text-slate-500 mt-4 font-bold uppercase tracking-[0.3em] opacity-60 italic">Onboarding Authorization Protocol</p>
                        </div>

                        <form action="{{ route('admin.suppliers.store') }}" method="POST" class="space-y-8">
                            @csrf

                            <div class="space-y-3">
                                <label class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.4em] ml-1 block">Entity ID</label>
                                <input type="text" name="name" required placeholder="Legal Name..."
                                    class="w-full bg-white/[0.02] border border-white/5 rounded-2xl px-6 py-4 text-white text-sm focus:border-indigo-500/50 transition-all outline-none">
                            </div>

                            <div class="space-y-3">
                                <label class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.4em] ml-1 block">Contact Link</label>
                                <input type="email" name="email" required placeholder="admin@node-identifier.com"
                                    class="w-full bg-white/[0.02] border border-white/5 rounded-2xl px-6 py-4 text-white text-sm focus:border-indigo-500/50 transition-all outline-none">
                            </div>

                            <div class="grid grid-cols-2 gap-6">
                                <div class="space-y-3">
                                    <label class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.4em] ml-1 block">Cipher</label>
                                    <input type="password" name="password" required
                                        class="w-full bg-white/[0.02] border border-white/5 rounded-2xl px-6 py-4 text-white text-sm focus:border-indigo-500/50 outline-none">
                                </div>
                                <div class="space-y-3">
                                    <label class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.4em] ml-1 block">Verify</label>
                                    <input type="password" name="password_confirmation" required
                                        class="w-full bg-white/[0.02] border border-white/5 rounded-2xl px-6 py-4 text-white text-sm focus:border-indigo-500/50 outline-none">
                                </div>
                            </div>

                            <div class="pt-10 flex gap-6">
                                <button type="button" @click="openAddModal = false"
                                    class="flex-1 py-5 bg-white/5 hover:bg-white/10 rounded-2xl text-[10px] font-bold text-slate-500 hover:text-white uppercase tracking-[0.3em] transition-all">
                                    Abort
                                </button>

                                <button type="submit"
                                    class="flex-1 py-5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.3em] transition-all shadow-xl shadow-indigo-600/30 flex items-center justify-center gap-3 group">
                                    <span>Integrate</span>
                                    <span class="text-amber-400 group-hover:translate-x-1 transition-transform">⚡</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="flex justify-center gap-12 opacity-20 py-6">
                <span class="text-[8px] font-bold text-slate-500 uppercase tracking-[0.4em]">Internal System v1.02</span>
                <span class="text-[8px] font-bold text-slate-500 uppercase tracking-[0.4em]">AES-256 Protocol</span>
            </div>
        </div>
    </div>
</x-app-layout>