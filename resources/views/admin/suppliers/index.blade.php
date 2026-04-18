<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <span class="text-indigo-400 font-semibold text-xs tracking-widest">NETWORK</span>
            <span class="h-4 w-[1px] bg-white/10"></span>
            <span class="text-white font-medium tracking-tight">Partner Distribution</span>
        </div>
    </x-slot>

    <div class="py-6 space-y-8">
        <!-- Header Card -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-6 bg-[#0d0f14] border border-white/[0.05] p-8 rounded-[2.5rem] shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-r from-indigo-500/5 to-transparent pointer-events-none"></div>
            
            <div class="relative z-10">
                <h3 class="text-white font-semibold text-3xl tracking-tighter">Supplier Infrastructure</h3>
                <p class="text-slate-400 text-sm mt-2">
                    Managing {{ $suppliers->count() }} active suppliers
                </p>
            </div>

            <button onclick="document.getElementById('onboardModal').showModal()" 
                class="px-6 py-3 bg-indigo-600 hover:bg-indigo-500 text-white rounded-2xl text-sm font-semibold tracking-wide transition-all active:scale-95 shadow-lg shadow-indigo-500/20">
                + Add New Supplier
            </button>
        </div>

        <!-- Premium Supplier Cards - Smaller & More Luxurious -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
            @forelse($suppliers as $supplier)
            <div class="group relative bg-[#0a0c12] border border-white/[0.06] hover:border-indigo-400/40 rounded-3xl p-6 transition-all duration-500 overflow-hidden shadow-2xl hover:shadow-indigo-500/10">
                
                <!-- Luxury Background Glow -->
                <div class="absolute -right-20 -top-20 w-72 h-72 bg-gradient-to-br from-indigo-500/10 to-violet-500/5 blur-[100px] group-hover:blur-[110px] transition-all duration-700"></div>

                <div class="flex items-start gap-5 relative z-10">
                    <!-- Avatar -->
                    <div class="relative shrink-0">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-[#1a1f2e] to-[#12151f] border border-white/10 flex items-center justify-center text-2xl font-semibold text-slate-200 shadow-inner group-hover:scale-105 transition-all duration-500">
                            {{ substr($supplier->name, 0, 1) }}
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 rounded-full border-[3.5px] border-[#0a0c12] shadow-[0_0_12px_rgba(16,185,129,0.6)]"></div>
                    </div>
                    
                    <!-- Main Info -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-3">
                            <h4 class="text-lg font-semibold text-white tracking-tight truncate">{{ $supplier->name }}</h4>
                            <span class="shrink-0 text-xs font-medium px-3.5 py-1 bg-emerald-500/10 text-emerald-400 rounded-full border border-emerald-500/20">
                                Active
                            </span>
                        </div>
                        <p class="text-slate-400 text-sm mt-1 truncate">{{ $supplier->email }}</p>
                        
                        <!-- Stats -->
                        <div class="grid grid-cols-2 gap-6 mt-7">
                            <div>
                                <p class="text-xs text-slate-500 font-medium">Total Orders</p>
                                <p class="text-2xl font-semibold text-white tracking-tighter mt-1">
                                    {{ $supplier->orders_count ?? 0 }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 font-medium">Supplier ID</p>
                                <p class="text-2xl font-semibold text-slate-300 tracking-tighter mt-1">
                                    #{{ str_pad($supplier->id, 3, '0', STR_PAD_LEFT) }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Button -->
                    <form action="{{ route('admin.suppliers.destroy', $supplier) }}" method="POST" 
                          onsubmit="return confirm('Remove this supplier?')">
                        @csrf
                        @method('DELETE')
                        <button class="w-9 h-9 rounded-2xl bg-white/[0.03] border border-white/10 flex items-center justify-center text-slate-500 hover:text-red-400 hover:bg-red-500/10 hover:border-red-500/30 transition-all mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>
                </div>

                <!-- Footer - Clean & Formal -->
                <div class="mt-8 pt-6 border-t border-white/[0.04] flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-sm">
                    <div class="flex items-center gap-2">
                        <span class="text-slate-500 text-xs">Uptime:</span>
                        <span class="text-emerald-500 font-medium">99.98%</span>
                    </div>
                    <p class="text-slate-500 text-xs">
                        Since {{ $supplier->created_at->format('F Y') }}
                    </p>
                </div>
            </div>
            @empty
            <div class="col-span-full py-20 text-center bg-[#0a0c12] rounded-3xl border border-dashed border-white/10">
                <div class="text-5xl mb-5 opacity-25">📡</div>
                <p class="text-slate-400 text-lg">No suppliers found</p>
                <p class="text-slate-500 text-sm mt-2">Add a new supplier to begin</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Premium Onboarding Modal -->
    <dialog id="onboardModal" class="bg-[#0a0c12] border border-white/10 p-0 rounded-[2.75rem] shadow-[0_60px_130px_rgba(0,0,0,0.9)] backdrop:backdrop-blur-2xl w-full max-w-md overflow-hidden relative">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-indigo-600/10 blur-[120px]"></div>
        
        <div class="p-10 relative z-10">
            <div class="flex justify-between items-center mb-10">
                <div>
                    <h3 class="text-white font-semibold text-3xl tracking-tighter">Add New Supplier</h3>
                    <p class="text-indigo-400 text-sm mt-1.5">Strategic Partner Onboarding</p>
                </div>
                <button onclick="this.closest('dialog').close()" 
                        class="w-10 h-10 rounded-2xl bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition-all text-2xl leading-none">
                    ×
                </button>
            </div>
            
            <form action="{{ route('admin.suppliers.store') }}" method="POST" class="space-y-8">
                @csrf
                
                <div class="space-y-7">
                    <div>
                        <label class="block text-xs font-medium text-slate-400 mb-2 tracking-wide">Organization Name</label>
                        <input type="text" name="name" required 
                               class="w-full bg-[#11141f] border border-white/10 focus:border-indigo-500 rounded-2xl px-6 py-4 text-white placeholder-slate-500 focus:ring-1 focus:ring-indigo-500/30 transition-all text-base"
                               placeholder="Nexus Global Logistics">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-400 mb-2 tracking-wide">Email Address</label>
                        <input type="email" name="email" required 
                               class="w-full bg-[#11141f] border border-white/10 focus:border-indigo-500 rounded-2xl px-6 py-4 text-white placeholder-slate-500 focus:ring-1 focus:ring-indigo-500/30 transition-all text-base"
                               placeholder="admin@nexus-global.com">
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-medium text-slate-400 mb-2 tracking-wide">Password</label>
                            <input type="password" name="password" required 
                                   class="w-full bg-[#11141f] border border-white/10 focus:border-indigo-500 rounded-2xl px-6 py-4 text-white placeholder-slate-500 focus:ring-1 focus:ring-indigo-500/30 transition-all text-base">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-400 mb-2 tracking-wide">Confirm Password</label>
                            <input type="password" name="password_confirmation" required 
                                   class="w-full bg-[#11141f] border border-white/10 focus:border-indigo-500 rounded-2xl px-6 py-4 text-white placeholder-slate-500 focus:ring-1 focus:ring-indigo-500/30 transition-all text-base">
                        </div>
                    </div>
                </div>

                <button type="submit" 
                        class="w-full mt-6 bg-gradient-to-r from-indigo-600 via-indigo-500 to-violet-600 hover:brightness-110 text-white py-5 rounded-2xl text-sm font-semibold tracking-[0.5px] shadow-2xl shadow-indigo-500/40 active:scale-[0.985] transition-all duration-300">
                    DEPLOY SUPPLIER
                </button>
            </form>
        </div>
    </dialog>
</x-app-layout>