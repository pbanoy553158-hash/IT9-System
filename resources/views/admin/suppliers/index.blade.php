<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <span class="text-[#5046e5] font-semibold text-xs tracking-widest">Network</span>
            <span class="h-4 w-[1px] bg-white/10"></span>
            <span class="text-white font-medium tracking-tight">
                Partner Distribution Portal
            </span>
        </div>
    </x-slot>

    <style>
        .btn-primary-violet {
            background: #5046e5;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(80, 70, 229, 0.25);
        }

        .btn-primary-violet:hover {
            background: #4338ca;
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(80, 70, 229, 0.35);
        }

        .supplier-card {
            background: linear-gradient(145deg, rgba(27,25,49,0.65), rgba(13,11,26,0.85));
            transition: all 0.3s ease;
        }

        .supplier-card:hover {
            transform: translateY(-3px);
            border-color: rgba(80,70,229,0.35);
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }

        dialog::backdrop {
            background: rgba(0,0,0,0.75);
            backdrop-filter: blur(6px);
        }
    </style>

    <div class="py-8 space-y-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Notifications --}}
        @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500/20 rounded-2xl p-4">
                <p class="text-red-400 text-xs font-medium mb-2">Please review the following errors:</p>
                <ul class="text-xs text-red-300 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="bg-emerald-500/10 border border-emerald-500/20 rounded-2xl p-4">
                <p class="text-emerald-300 text-xs font-medium">
                    {{ session('success') }}
                </p>
            </div>
        @endif

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 bg-[#1b1931]/40 border border-white/5 p-8 rounded-3xl">
            <div>
                <h1 class="text-white text-2xl font-semibold tracking-tight">
                    Supplier Management
                </h1>
                <p class="text-slate-400 text-xs mt-2">
                    Manage verified supplier accounts and onboarding requests
                </p>
            </div>

            <button onclick="document.getElementById('onboardModal').showModal()"
                class="btn-primary-violet px-6 py-3 rounded-xl text-white text-xs font-semibold tracking-wide">
                Add New Supplier
            </button>
        </div>

        {{-- Supplier Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">

            @forelse($suppliers as $supplier)
                <div class="supplier-card relative border border-white/5 rounded-2xl p-5">

                    <form method="POST"
                          action="{{ route('admin.suppliers.destroy', $supplier->id) }}"
                          class="absolute top-4 right-4">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            onclick="return confirm('Delete this supplier permanently?')"
                            class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/5 hover:bg-red-500/10 text-slate-400 hover:text-red-400 transition">
                            🗑
                        </button>
                    </form>

                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 rounded-xl bg-[#0d0b1a] border border-[#5046e5]/20 flex items-center justify-center">
                            <span class="text-[#818cf8] font-semibold text-xs">
                                {{ strtoupper(substr($supplier->name, 0, 1)) }}
                            </span>
                        </div>

                        <div>
                            <h4 class="text-white font-medium text-sm">
                                {{ $supplier->name }}
                            </h4>
                            <p class="text-slate-500 text-[11px]">
                                {{ $supplier->email }}
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-white/[0.02] border border-white/5 rounded-xl p-3">
                            <p class="text-[10px] text-slate-500">Total Orders</p>
                            <p class="text-lg text-white font-semibold mt-1">
                                {{ $supplier->orders_count ?? 0 }}
                            </p>
                        </div>

                        <div class="bg-white/[0.02] border border-white/5 rounded-xl p-3">
                            <p class="text-[10px] text-slate-500">Supplier ID</p>
                            <p class="text-lg text-[#818cf8] font-semibold mt-1">
                                #{{ str_pad($supplier->id, 3, '0', STR_PAD_LEFT) }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-t border-white/5 flex justify-between text-[10px] text-slate-500">
                        <span>Status: Active</span>
                        <span>{{ $supplier->created_at->format('M Y') }}</span>
                    </div>

                </div>
            @empty
                <div class="col-span-full text-center py-16 text-slate-500 text-xs">
                    No suppliers have been registered yet.
                </div>
            @endforelse

        </div>
    </div>

    {{-- MODAL WITH CLOSE X --}}
    <dialog id="onboardModal" class="bg-[#0d0f14] border border-white/10 rounded-3xl w-full max-w-md p-8 relative">

        {{-- Top Right Close Button --}}
        <button type="button"
            onclick="document.getElementById('onboardModal').close()"
            class="absolute top-4 right-4 w-9 h-9 flex items-center justify-center rounded-xl bg-white/5 hover:bg-red-500/10 text-slate-400 hover:text-red-400 transition">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-4 h-4"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <h3 class="text-white text-xl font-semibold mb-6">
            Supplier Onboarding
        </h3>

        <form method="POST" action="{{ route('admin.suppliers.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="text-xs text-slate-400">Company Name</label>
                <input type="text" name="name"
                       class="w-full mt-1 bg-white/5 border border-white/10 rounded-xl p-3 text-white text-sm"
                       placeholder="Enter company name">
            </div>

            <div>
                <label class="text-xs text-slate-400">Email Address</label>
                <input type="email" name="email"
                       class="w-full mt-1 bg-white/5 border border-white/10 rounded-xl p-3 text-white text-sm"
                       placeholder="company@email.com">
            </div>

            <div>
                <label class="text-xs text-slate-400">Password</label>
                <input type="password" name="password"
                       class="w-full mt-1 bg-white/5 border border-white/10 rounded-xl p-3 text-white text-sm">
            </div>

            <div>
                <label class="text-xs text-slate-400">Confirm Password</label>
                <input type="password" name="password_confirmation"
                       class="w-full mt-1 bg-white/5 border border-white/10 rounded-xl p-3 text-white text-sm">
            </div>

            <button type="submit"
                    class="btn-primary-violet w-full py-3 rounded-xl text-white text-sm font-semibold mt-2">
                Create Supplier Account
            </button>
        </form>

    </dialog>
</x-app-layout>