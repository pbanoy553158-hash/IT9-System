<x-guest-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    body {
        background-color: #030406;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .ecosystem-spotlight {
        background: radial-gradient(circle at 50% -20%, rgba(79, 70, 229, 0.15) 0%, transparent 50%);
    }

    .vault-card {
        background: rgba(15, 17, 22, 0.6);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    .login-container {
        width: 100%;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
    }

    .input-inset {
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .input-inset:focus {
        border-color: #6366f1;
        box-shadow: 0 0 15px rgba(99, 102, 241, 0.1);
    }
</style>

<div class="min-h-screen ecosystem-spotlight flex items-center justify-center px-4">

    <div class="login-container space-y-8">

        {{-- BRAND HEADER (Matching Login) --}}
        <div class="flex flex-col items-center">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center text-xl shadow-2xl mb-4">
                📦
            </div>

            <h1 class="text-xl font-extrabold text-white tracking-tight">
                Supply<span class="text-indigo-500">Manager</span>
            </h1>

            <p class="text-slate-500 text-[10px] font-semibold mt-1 tracking-wide uppercase">
                Recovery Terminal
            </p>
        </div>

        <div class="vault-card rounded-[2rem] p-8 shadow-2xl">
            {{-- DESCRIPTION TEXT --}}
            <div class="mb-6 text-xs leading-relaxed text-slate-400 px-1">
                {{ __('Forgot your password? No problem. Enter your email address and we will transmit a reset link to your terminal.') }}
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div class="space-y-2">
                    <label for="email" class="block text-[11px] font-semibold text-slate-400 ml-1">
                        Registered Email
                    </label>

                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full rounded-xl px-4 py-3 text-white text-sm input-inset outline-none transition-all"
                        placeholder="name@company.com">
                    
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-[10px]" />
                </div>

                <div class="space-y-4">
                    <button type="submit"
                        class="w-full py-3 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-sm font-semibold transition-all shadow-lg shadow-indigo-600/20 active:scale-[0.98]">
                        Transmit Reset Link
                    </button>

                    <div class="text-center">
                        <a href="{{ route('login') }}" class="text-[10px] font-bold text-slate-500 hover:text-indigo-400 uppercase tracking-widest transition-colors">
                            ← Back to Command Center
                        </a>
                    </div>
                </div>
            </form>
        </div>

        {{-- FOOTER --}}
        <p class="text-center text-[10px] text-slate-600 font-medium tracking-wide">
            Secure recovery • system v4.2
        </p>

    </div>
</div>
</x-guest-layout>