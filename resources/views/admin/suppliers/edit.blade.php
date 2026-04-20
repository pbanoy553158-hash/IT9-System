<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-[10px] tracking-widest uppercase font-bold">
                    <li>
                        <a href="{{ route('admin.suppliers.index') }}"
                           class="text-[#5046e5] hover:text-white transition">
                            Network
                        </a>
                    </li>
                    <li class="text-white/20">/</li>
                    <li class="text-white/90">
                        Edit Supplier
                    </li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <style>
        .ocean-dark-panel {
            background: linear-gradient(145deg, #121121 0%, #080712 100%);
            border: 1px solid rgba(255,255,255,0.04);
            box-shadow: 0 30px 80px rgba(0,0,0,0.5);
        }

        .btn-primary-glow {
            background: #5046e5;
            box-shadow: 0 0 20px rgba(80,70,229,0.25);
            transition: all 0.2s ease;
        }

        .btn-primary-glow:hover {
            background: #6366f1;
            box-shadow: 0 0 25px rgba(80,70,229,0.4);
            transform: translateY(-1px);
        }

        .standard-input {
            width: 100%;
            background: #080712;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 0.75rem;
            padding: 0.75rem 1rem; 
            color: white;
            font-size: 0.875rem;
            outline: none;
            transition: all 0.2s ease;
        }

        .standard-input:focus {
            border-color: rgba(80, 70, 229, 0.5);
            background: #0c0b1a;
        }

        .standard-input::placeholder {
            color: #334155;
        }
    </style>

    <div class="py-12">
        <div class="max-w-md mx-auto px-6">

            <div class="ocean-dark-panel rounded-[2rem] p-8 shadow-2xl">

                <div class="mb-8">
                    <h2 class="text-white text-xl font-bold tracking-tight">
                        Update Partner Node
                    </h2>
                    <p class="text-slate-500 text-[10px] mt-1 italic">
                        Modifying Identity #{{ str_pad($supplier->id, 3, '0', STR_PAD_LEFT) }}
                    </p>
                </div>

                <form method="POST"
                      action="{{ route('admin.suppliers.update', $supplier->id) }}"
                      class="space-y-5">

                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="text-[11px] font-semibold text-slate-400 ml-1 mb-1.5 block">Company Name</label>
                        <input type="text"
                               name="name"
                               value="{{ old('name', $supplier->name) }}"
                               required
                               class="standard-input"
                               placeholder="Princess Mae Banoy">
                        @error('name')
                            <p class="text-rose-500 text-[10px] mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="text-[11px] font-semibold text-slate-400 ml-1 mb-1.5 block">Email Address</label>
                        <input type="email"
                               name="email"
                               value="{{ old('email', $supplier->email) }}"
                               required
                               class="standard-input"
                               placeholder="partner@network.com">
                        @error('email')
                            <p class="text-rose-500 text-[10px] mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4 border-t border-white/5 space-y-4">
                        <div>
                            <p class="text-[11px] font-semibold text-slate-500 mb-3 ml-1">Security Update (Optional)</p>

                            <div class="grid grid-cols-1 gap-3">
                                <input type="password"
                                       name="password"
                                       class="standard-input"
                                       placeholder="New Password">

                                <input type="password"
                                       name="password_confirmation"
                                       class="standard-input"
                                       placeholder="Confirm Password">
                            </div>

                            <p class="text-[10px] text-slate-600 mt-3 italic ml-1">
                                Leave blank to maintain current credentials.
                            </p>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-3 pt-6">
                        <button type="submit"
                                class="btn-primary-glow flex-1 py-3.5 rounded-xl text-white text-[11px] font-bold tracking-wide">
                            Save Changes
                        </button>

                        <a href="{{ route('admin.suppliers.index') }}"
                           class="px-5 py-3.5 text-slate-400 hover:text-white text-[11px] font-bold transition-colors">
                            Cancel
                        </a>
                    </div>

                </form>
            </div>

        </div>
    </div>
</x-app-layout>