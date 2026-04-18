<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <span class="text-indigo-400 font-semibold text-xs tracking-widest">ACCOUNT</span>
            <span class="h-4 w-[1px] bg-white/10"></span>
            <span class="text-white font-medium tracking-tight">Profile Settings</span>
        </div>
    </x-slot>

    <div class="p-8">
        <div class="max-w-lg mx-auto">
            
            <!-- Compact Premium Card -->
            <div class="bg-[#11141f]/95 backdrop-blur-xl border border-white/[0.08] rounded-3xl shadow-2xl overflow-hidden">
                
                <!-- Card Header -->
                <div class="px-8 pt-8 pb-5 border-b border-white/[0.06]">
                    <h2 class="text-xl font-semibold text-white tracking-tight">Profile Settings</h2>
                    <p class="text-slate-400 text-sm mt-1">Update your account details</p>
                </div>

                <div class="p-8 space-y-10">
                    
                    <!-- Profile Information -->
                    <div>
                        <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <!-- Name -->
                            <div>
                                <label class="block text-xs font-medium text-slate-400 mb-2">Full Name</label>
                                <input 
                                    type="text" 
                                    name="name" 
                                    value="{{ old('name', $user->name) }}" 
                                    required
                                    class="w-full bg-[#1a1f2e] border border-white/10 focus:border-indigo-500 rounded-2xl px-5 py-3.5 text-sm text-white placeholder-slate-500 transition-all">
                                @error('name')
                                    <p class="mt-1 text-red-400 text-xs">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-xs font-medium text-slate-400 mb-2">Email Address</label>
                                <input 
                                    type="email" 
                                    name="email" 
                                    value="{{ old('email', $user->email) }}" 
                                    required
                                    class="w-full bg-[#1a1f2e] border border-white/10 focus:border-indigo-500 rounded-2xl px-5 py-3.5 text-sm text-white placeholder-slate-500 transition-all">
                                @error('email')
                                    <p class="mt-1 text-red-400 text-xs">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit"
                                    class="w-full mt-6 bg-gradient-to-r from-indigo-600 to-violet-600 hover:brightness-110 text-white py-4 rounded-2xl text-sm font-semibold tracking-widest transition-all active:scale-[0.98]">
                                Save Changes
                            </button>
                        </form>
                    </div>

                    <!-- Password Section -->
                    <div class="pt-6 border-t border-white/[0.06]">
                        <h3 class="text-base font-medium text-white mb-5">Change Password</h3>
                        
                        <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <div>
                                <label class="block text-xs font-medium text-slate-400 mb-2">Current Password</label>
                                <input type="password" name="current_password" 
                                       class="w-full bg-[#1a1f2e] border border-white/10 focus:border-indigo-500 rounded-2xl px-5 py-3.5 text-sm text-white transition-all">
                                @error('current_password')
                                    <p class="mt-1 text-red-400 text-xs">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-medium text-slate-400 mb-2">New Password</label>
                                    <input type="password" name="password" 
                                           class="w-full bg-[#1a1f2e] border border-white/10 focus:border-indigo-500 rounded-2xl px-5 py-3.5 text-sm text-white transition-all">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-400 mb-2">Confirm Password</label>
                                    <input type="password" name="password_confirmation" 
                                           class="w-full bg-[#1a1f2e] border border-white/10 focus:border-indigo-500 rounded-2xl px-5 py-3.5 text-sm text-white transition-all">
                                </div>
                            </div>

                            <button type="submit"
                                    class="w-full mt-6 bg-white/10 hover:bg-white/15 border border-white/10 text-white py-4 rounded-2xl text-sm font-semibold tracking-widest transition-all">
                                Update Password
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>