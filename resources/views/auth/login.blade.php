<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center items-center bg-[#0a0b10] px-6 selection:bg-indigo-500/30">
        
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[30rem] h-[30rem] bg-indigo-500/10 blur-[120px] rounded-full"></div>
            <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 40px 40px;"></div>
        </div>

        <div class="mb-10 text-center relative z-10">
            <h2 class="text-3xl font-light text-white tracking-tight">Supply<span class="text-indigo-400 font-semibold">Manager</span></h2>
            <p class="text-slate-400 text-xs mt-2 font-light tracking-wide">Enter your credentials to access the network.</p>
        </div>

        <div class="w-full max-w-[400px] bg-[#11131a]/80 border border-white/[0.1] p-10 rounded-[2rem] backdrop-blur-3xl shadow-2xl relative z-10">
            
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-300 mb-2 ml-1">Email address</label>
                    <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                        class="w-full bg-[#0a0b10]/50 border-white/10 rounded-xl text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 placeholder-slate-600 py-3.5 px-4 text-sm transition-all" 
                        placeholder="admin@supplymanager.com">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-400" />
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2 ml-1">
                        <label for="password" class="block text-sm font-medium text-slate-300">Password</label>
                        @if (Route::has('password.request'))
                            <a class="text-xs text-indigo-400 hover:text-indigo-300 transition-colors" href="{{ route('password.request') }}">
                                Forgot?
                            </a>
                        @endif
                    </div>
                    <input id="password" type="password" name="password" required 
                        class="w-full bg-[#0a0b10]/50 border-white/10 rounded-xl text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 py-3.5 px-4 text-sm transition-all"
                        placeholder="••••••••">
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-400" />
                </div>

                <div class="flex items-center ml-1">
                    <input id="remember_me" type="checkbox" name="remember" 
                        class="rounded bg-white/5 border-white/10 text-indigo-500 focus:ring-0 focus:ring-offset-0 w-4 h-4 cursor-pointer">
                    <span class="ms-3 text-sm text-slate-400 font-light">Stay logged in</span>
                </div>

                <div class="pt-2">
                    <button type="submit" 
                        class="w-full bg-indigo-600 hover:bg-indigo-500 text-white py-4 rounded-xl text-sm font-semibold transition-all shadow-[0_0_20px_rgba(79,70,229,0.4)] hover:shadow-[0_0_30px_rgba(79,70,229,0.6)] active:scale-[0.98]">
                        Sign in to Dashboard
                    </button>
                </div>
            </form>
        </div>

        <div class="mt-10 flex items-center gap-3 opacity-50">
            <div class="w-1.5 h-1.5 bg-indigo-500 rounded-full animate-pulse shadow-[0_0_10px_rgba(99,102,241,1)]"></div>
            <p class="text-slate-500 text-[10px] font-medium tracking-widest uppercase">Secure Admin Access</p>
        </div>
    </div>
</x-guest-layout>