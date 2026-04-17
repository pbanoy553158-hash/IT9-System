<x-app-layout>
    <x-slot name="header">
        <span class="font-medium text-slate-400 uppercase tracking-widest text-xs">Directory /</span>
        <span class="font-bold text-white uppercase tracking-widest text-xs ml-1">Partner Registration</span>
    </x-slot>

    <div class="min-h-screen py-16 px-6 bg-[radial-gradient(circle_at_top,_var(--tw-gradient-stops))] from-slate-900 via-[#050505] to-[#050505]">
        <div class="max-w-3xl mx-auto">
            
            <div class="mb-10">
                <a href="{{ route('admin.suppliers.index') }}" 
                   class="inline-flex items-center gap-3 text-xs font-bold text-slate-500 hover:text-white transition-all group tracking-[0.2em]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    RETURN TO DIRECTORY
                </a>
            </div>

            <div class="bg-[#0a0c12] border border-white/10 rounded-[32px] overflow-hidden shadow-[0_0_80px_-20px_rgba(255,255,255,0.08)]">
                <div class="p-10 md:p-14">
                    
                    <div class="mb-12 border-b border-white/5 pb-10">
                        <h3 class="text-3xl font-semibold text-white tracking-tight">Authorized <span class="text-indigo-500">Onboarding</span></h3>
                        <p class="text-sm text-slate-500 mt-3 font-medium leading-relaxed">
                            Configure secure credentials for a verified business partner.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('admin.suppliers.store') }}" class="space-y-10">
                        @csrf

                        <div class="space-y-3">
                            <label for="name" class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.25em] ml-1">
                                Legal Entity Name
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus 
                                   placeholder="e.g. Acme Global Industries"
                                   class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-6 py-4 text-sm text-white placeholder-slate-700 focus:outline-none focus:border-indigo-500/50 focus:ring-1 focus:ring-indigo-500/10 transition-all outline-none">
                            @error('name') <p class="text-red-500 text-[10px] font-bold mt-2 ml-2 tracking-widest uppercase">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-3">
                            <label for="email" class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.25em] ml-1">
                                Professional Email Address
                            </label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required 
                                   placeholder="procurement@partner-domain.com"
                                   class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-6 py-4 text-sm text-white placeholder-slate-700 focus:outline-none focus:border-indigo-500/50 focus:ring-1 focus:ring-indigo-500/10 transition-all outline-none">
                            @error('email') <p class="text-red-500 text-[10px] font-bold mt-2 ml-2 tracking-widest uppercase">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-3">
                                <label for="password" class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.25em] ml-1">
                                    Temporary Password
                                </label>
                                <input type="password" name="password" id="password" required 
                                       class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-6 py-4 text-sm text-white focus:outline-none focus:border-indigo-500/50 focus:ring-1 focus:ring-indigo-500/10 transition-all outline-none">
                                @error('password') <p class="text-red-500 text-[10px] font-bold mt-2 ml-2 tracking-widest uppercase">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-3">
                                <label for="password_confirmation" class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.25em] ml-1">
                                    Confirm Credentials
                                </label>
                                <input type="password" name="password_confirmation" id="password_confirmation" required 
                                       class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-6 py-4 text-sm text-white focus:outline-none focus:border-indigo-500/50 focus:ring-1 focus:ring-indigo-500/10 transition-all outline-none">
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-8 border-t border-white/5 pt-10 mt-12">
                            <a href="{{ route('admin.suppliers.index') }}" 
                               class="text-[10px] font-bold text-slate-500 hover:text-white uppercase tracking-[0.2em] transition-colors">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-10 py-5 bg-white text-black hover:bg-slate-200 rounded-xl font-bold text-xs uppercase tracking-[0.2em] transition-all shadow-[0_0_20px_rgba(255,255,255,0.1)] active:scale-95">
                                Register Supplier
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-10 flex justify-center opacity-20">
                <p class="text-[9px] font-bold text-slate-500 uppercase tracking-[0.4em]">Internal Administration Access Only</p>
            </div>
        </div>
    </div>
</x-app-layout>