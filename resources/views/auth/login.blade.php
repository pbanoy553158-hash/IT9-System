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

        {{-- LOGO --}}
        <div class="flex flex-col items-center">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center text-xl shadow-2xl mb-4">
                📦
            </div>

            <h1 class="text-xl font-extrabold text-white tracking-tight">
                Supply<span class="text-indigo-500">Manager</span>
            </h1>

            <p class="text-slate-500 text-[10px] font-semibold mt-1 tracking-wide">
                Command center access
            </p>
        </div>

        <div class="vault-card rounded-[2rem] p-8 shadow-2xl">
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div class="space-y-2">
                    <label class="block text-[11px] font-semibold text-slate-400 ml-1">
                        Email address
                    </label>

                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full rounded-xl px-4 py-3 text-white text-sm input-inset outline-none transition-all"
                        placeholder="name@company.com">
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between items-center ml-1">
                        <label class="text-[11px] font-semibold text-slate-400">
                            Password
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               class="text-[9px] text-indigo-400 hover:text-indigo-300 leading-none">
                                Forgot?
                            </a>
                        @endif
                    </div>

                    <input type="password" name="password" required
                        class="w-full rounded-xl px-4 py-3 text-white text-sm input-inset outline-none transition-all"
                        placeholder="••••••••">
                </div>

                <div class="flex items-center px-1">
                    <input type="checkbox" name="remember"
                        class="rounded bg-white/5 border-white/10 text-indigo-600 w-4 h-4">

                    <span class="ml-2 text-xs text-slate-500">
                        Keep me signed in
                    </span>
                </div>

                <button type="submit"
                    class="w-full py-3 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-sm font-semibold normal-case tracking-normal transition-all shadow-lg shadow-indigo-600/20 active:scale-[0.98]">
                    Authorize Access
                </button>

            </form>
        </div>

        {{-- FOOTER --}}
        <p class="text-center text-[10px] text-slate-600 font-medium tracking-wide">
            Secure login • system v4.2
        </p>

    </div>
</div>
</x-guest-layout>