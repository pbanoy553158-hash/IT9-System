<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <span class="text-[#5046e5] font-bold text-xs tracking-widest uppercase">Network</span>
            <span class="h-4 w-[1px] bg-white/10"></span>
            <span class="text-white font-medium tracking-tight text-lg">Partner Distribution Portal</span>
        </div>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        .font-inter { font-family: 'Inter', sans-serif !important; }

        .ocean-dark-panel {
            background: linear-gradient(145deg, #171629 0%, #0d0b1a 100%);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-ocean {
            background: linear-gradient(135deg, #5046e5 0%, #3730a3 100%);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 12px rgba(80, 70, 229, 0.2);
            text-transform: none !important;
            letter-spacing: -0.01em !important;
        }

        .btn-ocean:hover {
            filter: brightness(1.1);
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(80, 70, 229, 0.3);
        }

        .standard-input {
            width: 100%;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 0.75rem;
            padding: 0.75rem 0.9rem; 
            color: white;
            font-size: 0.85rem;
            outline: none;
            transition: all 0.2s ease;
        }

        .standard-input:focus {
            border-color: rgba(80, 70, 229, 0.5);
            background: rgba(80, 70, 229, 0.02);
        }

        dialog::backdrop {
            background: rgba(0, 0, 0, 0.85);
            backdrop-filter: blur(8px);
        }
    </style>

    <div class="py-10 space-y-8 max-w-[1400px] mx-auto px-4 font-inter antialiased">

        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row justify-between items-end gap-6 px-4">
            <div>
                <h1 class="text-white font-semibold text-3xl tracking-tighter leading-none">Supplier Nodes</h1>
                <p class="text-slate-500 text-sm mt-2 italic font-medium">Manage, verify, and track global asset movements</p>
            </div>
            
            <div class="flex items-center gap-3 pb-1">
                <button onclick="document.getElementById('onboardModal').showModal()"
                    class="btn-ocean px-6 py-3 rounded-xl text-white text-[12px] font-semibold transition-all inline-flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    Register New Supplier
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="mx-4 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl text-emerald-500 text-xs font-semibold flex items-center gap-3">
                <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 px-4">
            @forelse($suppliers as $supplier)
                <div class="ocean-dark-panel rounded-[2rem] p-6 relative group shadow-2xl">

                    <div class="absolute top-5 right-5 flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                        <a href="{{ route('admin.suppliers.edit', $supplier->id) }}" class="w-8 h-8 flex items-center justify-center bg-white/5 hover:bg-[#5046e5] text-slate-500 hover:text-white rounded-lg transition-all border border-white/5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                        <form method="POST" action="{{ route('admin.suppliers.destroy', $supplier->id) }}" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Erase node record?')" class="w-8 h-8 flex items-center justify-center bg-rose-500/5 hover:bg-rose-500 text-rose-500 hover:text-white rounded-lg transition-all border border-rose-500/10 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>

                    <div class="flex flex-col items-center text-center mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-[#5046e5]/10 border border-white/5 flex items-center justify-center mb-4 shadow-inner group-hover:border-[#5046e5]/40 transition-all">
                            <span class="text-[#818cf8] font-black text-lg">{{ substr($supplier->name, 0, 1) }}</span>
                        </div>
                        <h4 class="text-white font-bold text-base tracking-tight truncate w-full px-2 group-hover:text-[#5046e5] transition-colors">{{ $supplier->name }}</h4>
                        <p class="text-slate-500 text-xs mt-1.5 font-medium tracking-tight">{{ $supplier->email }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-white/[0.02] border border-white/[0.03] rounded-2xl py-3 text-center">
                            <span class="text-[10px] text-slate-600 block font-bold tracking-tight mb-1 uppercase">Orders</span>
                            <span class="text-sm text-white font-bold tracking-tight">{{ $supplier->orders_count ?? 0 }}</span>
                        </div>
                        <div class="bg-white/[0.02] border border-white/[0.03] rounded-2xl py-3 text-center">
                            <span class="text-[10px] text-slate-600 block font-bold tracking-tight mb-1 uppercase">Node ID</span>
                            <span class="text-sm text-[#818cf8] font-mono font-bold tracking-tight">#{{ str_pad($supplier->id, 3, '0', STR_PAD_LEFT) }}</span>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-white/5 flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <div class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></div>
                            <span class="text-[10px] text-emerald-500 font-bold tracking-widest uppercase">Online</span>
                        </div>
                        <span class="text-[10px] text-slate-600 font-medium italic">Est. {{ $supplier->created_at->format('M Y') }}</span>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16 ocean-dark-panel rounded-[2rem]">
                    <p class="text-slate-500 text-sm font-medium italic">No active nodes detected in directory</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Modal Registration --}}
    <dialog id="onboardModal" class="bg-transparent focus:outline-none">
        <div class="ocean-dark-panel rounded-[2.5rem] p-10 w-full max-w-[420px] shadow-2xl border border-white/10 font-inter">
            <div class="mb-8">
                <h3 class="text-white font-semibold text-2xl tracking-tighter">Onboard Partner</h3>
                <p class="text-slate-500 text-xs mt-2 italic font-medium">Initialize a new distribution node</p>
            </div>

            <form method="POST" action="{{ route('admin.suppliers.store') }}" class="space-y-5">
                @csrf
                <div class="space-y-2">
                    <label class="text-[13px] font-semibold text-slate-400 ml-1">Company name</label>
                    <input type="text" name="name" placeholder="Full entity name" required class="standard-input">
                </div>

                <div class="space-y-2">
                    <label class="text-[13px] font-semibold text-slate-400 ml-1">Access email</label>
                    <input type="email" name="email" placeholder="partner@network.com" required class="standard-input">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-[13px] font-semibold text-slate-400 ml-1">Password</label>
                        <input type="password" name="password" required class="standard-input">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[13px] font-semibold text-slate-400 ml-1">Confirm password</label>
                        <input type="password" name="password_confirmation" required class="standard-input">
                    </div>
                </div>

                <div class="flex items-center gap-4 pt-6">
                    <button type="submit" class="btn-ocean flex-1 py-4 rounded-xl text-white text-[14px] font-semibold tracking-tight transition-all">
                        Deploy partner node
                    </button>
                    <button type="button" onclick="document.getElementById('onboardModal').close()" class="px-6 py-4 text-slate-500 hover:text-white text-[14px] font-medium transition-colors tracking-tight">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </dialog>
</x-app-layout>