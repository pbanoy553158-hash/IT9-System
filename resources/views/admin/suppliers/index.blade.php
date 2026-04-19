<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <span class="text-[#5046e5] font-semibold text-xs tracking-widest uppercase">Network</span>
            <span class="h-4 w-[1px] bg-white/10"></span>
            <span class="text-white font-medium tracking-tight">Partner Distribution Portal</span>
        </div>
    </x-slot>

    <style>
        .btn-primary-violet {
            background: #5046e5;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 15px 0 rgba(80, 70, 229, 0.3);
        }
        .btn-primary-violet:hover {
            background: #4338ca;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px 0 rgba(80, 70, 229, 0.4);
        }

        .supplier-card {
            background: linear-gradient(145deg, rgba(27, 25, 49, 0.6) 0%, rgba(13, 11, 26, 0.8) 100%);
            transition: all 0.4s ease;
        }

        .supplier-card:hover {
            border-color: rgba(80, 70, 229, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 15px 30px -10px rgba(0, 0, 0, 0.5);
        }

        dialog::backdrop {
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(8px);
        }
    </style>

    <div class="py-6 space-y-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- HEADER (UNCHANGED) --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 bg-[#1b1931]/40 border border-white/5 p-8 rounded-[2.5rem] shadow-2xl relative overflow-hidden">

            <div class="absolute inset-0 bg-gradient-to-r from-[#5046e5]/5 to-transparent pointer-events-none"></div>

            <div class="relative z-10">
                <h1 class="text-white font-semibold text-3xl tracking-tighter">Supplier Infrastructure</h1>

                <div class="mt-3 flex items-center">
                    <span class="flex items-center gap-2 px-3 py-1 bg-[#5046e5]/10 border border-[#5046e5]/20 rounded-full">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#818cf8] opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-[#5046e5]"></span>
                        </span>
                        <span class="text-slate-400 text-xs font-medium tracking-tight">
                            Active Authorized Partners:
                        </span>
                        <span class="text-[#818cf8] text-xs font-bold ml-1">
                            {{ $suppliers->count() }}
                        </span>
                    </span>
                </div>
            </div>

            <button onclick="document.getElementById('onboardModal').showModal()"
                class="btn-primary-violet px-6 py-3.5 text-white rounded-xl font-bold text-xs tracking-wide transition-all active:scale-95 relative z-10 flex items-center gap-2">

                <span class="opacity-70 font-normal text-lg leading-none">+</span>
                Add Supplier
            </button>

        </div>

        {{-- GRID --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">

            {{-- ✅ IMPROVED SUPPLIER CARD --}}
            @forelse($suppliers as $supplier)
        <div class="supplier-card group border border-white/5 rounded-xl p-4 relative overflow-hidden">

            {{-- subtle controlled accent (very minimal now) --}}
            <div class="absolute -right-10 -top-10 w-28 h-28 bg-[#5046e5]/5 blur-2xl"></div>

            <div class="relative z-10 flex flex-col gap-4">

                {{-- HEADER --}}
                <div class="flex items-center justify-between">

                    <div class="flex items-center gap-3 min-w-0">

                        <div class="w-9 h-9 rounded-lg bg-[#0d0b1a] border border-[#5046e5]/20 flex items-center justify-center">
                            <span class="text-[#818cf8] font-semibold text-xs">
                                {{ strtoupper(substr($supplier->name, 0, 1)) }}
                            </span>
                        </div>

                        <div class="min-w-0">
                            <h4 class="text-white font-medium text-sm truncate">
                                {{ $supplier->name }}
                            </h4>
                            <p class="text-[10px] text-slate-500 truncate">
                                {{ $supplier->email }}
                            </p>
                        </div>

                    </div>

                    {{-- status --}}
                    <span class="text-[9px] px-2 py-0.5 rounded-md bg-[#5046e5]/10 text-[#818cf8] border border-[#5046e5]/10 uppercase tracking-widest font-semibold">
                        Active
                    </span>

                </div>

                {{-- STATS --}}
                <div class="grid grid-cols-2 gap-3">

                    <div class="bg-white/[0.02] border border-white/5 rounded-lg p-3">
                        <p class="text-[9px] text-slate-500 uppercase tracking-widest">Orders</p>
                        <p class="text-lg font-semibold text-white mt-1">
                            {{ $supplier->orders_count ?? 0 }}
                        </p>
                    </div>

                    <div class="bg-white/[0.02] border border-white/5 rounded-lg p-3">
                        <p class="text-[9px] text-slate-500 uppercase tracking-widest">ID</p>
                        <p class="text-lg font-semibold text-[#818cf8] mt-1">
                            #{{ str_pad($supplier->id, 3, '0', STR_PAD_LEFT) }}
                        </p>
                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="flex items-center justify-between pt-2 border-t border-white/5">

                    <div class="flex items-center gap-2">
                        <div class="w-1 h-1 rounded-full bg-[#5046e5]"></div>
                        <span class="text-[9px] text-slate-500 uppercase tracking-widest">
                            Sync OK
                        </span>
                    </div>

                    <span class="text-[9px] text-slate-600">
                        {{ $supplier->created_at->format('M Y') }}
                    </span>

                </div>

            </div>
        </div>

        @empty

        <div class="col-span-full py-16 text-center border border-dashed border-white/10 rounded-xl bg-[#0d0b1a]/40">
            <p class="text-slate-600 text-xs uppercase tracking-widest">
                No supplier records found
            </p>
        </div>

        @endforelse

    {{-- MODAL (UNCHANGED) --}}
    <dialog id="onboardModal" class="bg-[#0d0f14] border border-white/10 p-0 rounded-[2.5rem] shadow-2xl w-full max-w-md overflow-hidden outline-none">

        <div class="p-10">

            <div class="flex justify-between items-start mb-8">
                <div>
                    <h3 class="text-white font-bold text-2xl tracking-tighter">Onboard Supplier</h3>
                    <p class="text-slate-500 text-sm mt-1 font-medium">Initialize new authorized partner node.</p>
                </div>

                <button onclick="document.getElementById('onboardModal').close()"
                        class="w-10 h-10 flex items-center justify-center rounded-full bg-white/5 text-slate-500 hover:text-white transition-all hover:bg-white/10">
                    ×
                </button>
            </div>

            <form action="{{ route('admin.suppliers.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="space-y-5">

                    <input type="text" name="name" required
                        class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-5 py-4 text-sm text-white"
                        placeholder="Supplier Name">

                    <input type="email" name="email" required
                        class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-5 py-4 text-sm text-white"
                        placeholder="Email">

                </div>

                <button type="submit"
                        class="btn-primary-violet w-full text-white py-4 rounded-xl text-sm font-bold tracking-wide">
                    Deploy Supplier Node
                </button>

            </form>

        </div>

    </dialog>

</x-app-layout>