<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="p-2 bg-[#5046e5]/10 rounded-lg">
                <svg class="w-4 h-4 text-[#5046e5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-[#5046e5] font-semibold text-xs tracking-wider">Account</span>
                <span class="h-4 w-[1px] bg-white/10"></span>
                <span class="text-white font-medium tracking-tight">Identity manager</span>
            </div>
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
            box-shadow: 0 6px 20px 0 rgba(80, 70, 229, 0.4);
            transform: translateY(-1px);
        }

        .btn-secondary-violet {
            background: rgba(80, 70, 229, 0.05);
            border: 1px solid rgba(80, 70, 229, 0.2);
            transition: all 0.3s ease;
        }

        .btn-secondary-violet:hover {
            background: rgba(80, 70, 229, 0.1);
            border-color: rgba(80, 70, 229, 0.4);
            color: white;
        }
    </style>

    <div class="p-8">
        <div class="max-w-4xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-[#0d0f17] border border-white/5 rounded-[2.5rem] p-6 text-center relative overflow-hidden group shadow-2xl">
                    <div class="absolute inset-0 bg-gradient-to-b from-[#5046e5]/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="relative inline-block mb-4" x-data="{ photoPreview: null }">
                            <div class="w-28 h-28 rounded-full p-1 bg-gradient-to-tr from-[#5046e5] to-indigo-600 shadow-xl shadow-[#5046e5]/10">
                                <div class="w-full h-full rounded-full border-4 border-[#0d0f17] overflow-hidden bg-slate-800">
                                    <template x-if="!photoPreview">
                                        <img src="{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&color=7F9CF5&background=11141f' }}" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="photoPreview">
                                        <img :src="photoPreview" class="w-full h-full object-cover">
                                    </template>
                                </div>
                            </div>
                            
                            <label class="absolute bottom-0 right-0 w-8 h-8 bg-white hover:bg-[#5046e5] text-black hover:text-white rounded-xl flex items-center justify-center cursor-pointer shadow-lg transition-all border-4 border-[#0d0f17]">
                                <input type="file" name="photo" class="hidden" 
                                    @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result; }; reader.readAsDataURL(file); }">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-width="2.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </label>
                        </div>

                        <h3 class="text-white font-semibold text-base leading-tight truncate">{{ $user->name }}</h3>
                        <p class="text-[#5046e5] text-xs mt-1 font-medium">{{ $user->role ?? 'Authorized node' }}</p>

                        <div class="mt-6 pt-6 border-t border-white/5 space-y-2">
                            <div class="flex justify-between text-[11px]">
                                <span class="text-slate-500 font-medium">Member since</span>
                                <span class="text-slate-300">{{ $user->created_at->format('M Y') }}</span>
                            </div>
                            <div class="flex justify-between text-[11px]">
                                <span class="text-slate-500 font-medium">Status</span>
                                <span class="text-emerald-500 italic">Encrypted</span>
                            </div>
                        </div>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-6">
                {{-- Personal Details Card --}}
                <div class="bg-[#0d0f17] border border-white/5 rounded-[2.5rem] p-8 shadow-2xl relative">
                    <h2 class="text-lg font-semibold text-white tracking-tight mb-6">Personal details</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-semibold text-slate-400 pl-1">Full name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                class="w-full bg-white/[0.02] border border-white/10 focus:border-[#5046e5]/50 focus:ring-0 rounded-xl px-5 py-3 text-sm text-white transition-all">
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-xs font-semibold text-slate-400 pl-1">Email address</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                class="w-full bg-white/[0.02] border border-white/10 focus:border-[#5046e5]/50 focus:ring-0 rounded-xl px-5 py-3 text-sm text-white transition-all">
                        </div>
                    </div>

                    <div class="mt-8">
                        <button type="submit"
                                class="btn-primary-violet px-8 py-3.5 text-white rounded-xl text-xs font-bold tracking-wide transition-all active:scale-95">
                            Update identity
                        </button>
                    </div>
                </form>
                </div>

                {{-- Password Card --}}
                <div class="bg-[#0d0f17] border border-white/5 rounded-[2.5rem] p-8 shadow-2xl">
                    <h2 class="text-lg font-semibold text-white tracking-tight mb-6">Password update</h2>
                    
                    <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div class="space-y-1.5">
                            <label class="block text-xs font-semibold text-slate-400 pl-1">Current password</label>
                            <input type="password" name="current_password" 
                                class="w-full bg-white/[0.02] border border-white/10 focus:border-[#5046e5]/50 focus:ring-0 rounded-xl px-5 py-3 text-sm text-white transition-all">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-1.5">
                                <label class="block text-xs font-semibold text-slate-400 pl-1">New password</label>
                                <input type="password" name="password" 
                                    class="w-full bg-white/[0.02] border border-white/10 focus:border-[#5046e5]/50 focus:ring-0 rounded-xl px-5 py-3 text-sm text-white transition-all">
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-xs font-semibold text-slate-400 pl-1">Confirm password</label>
                                <input type="password" name="password_confirmation" 
                                    class="w-full bg-white/[0.02] border border-white/10 focus:border-[#5046e5]/50 focus:ring-0 rounded-xl px-5 py-3 text-sm text-white transition-all">
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit"
                                    class="btn-secondary-violet w-full py-3.5 text-slate-400 rounded-xl text-xs font-bold tracking-wide active:scale-[0.98]">
                                Update credentials
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>