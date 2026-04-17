<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SupplyManager • Intelligent Ecosystem</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #040508; 
            color: #e2e8f0;
        }

        /* SIDEBAR: Deep Violet Gradient & Right Border */
        .sidebar-premium {
            background: linear-gradient(165deg, #0f0c29 0%, #06080c 40%, #020305 100%);
            border-right: 1px solid rgba(139, 92, 246, 0.15); /* Violet edge */
            box-shadow: 10px 0 50px rgba(0, 0, 0, 0.5);
            position: relative;
        }

        /* VIOLET SPOTLIGHT GLOW */
        .sidebar-glow {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 10% 5%, rgba(139, 92, 246, 0.2) 0%, transparent 60%);
            pointer-events: none;
            z-index: 0;
        }

        /* Navigation Content Container */
        .nav-content {
            position: relative;
            z-index: 10;
        }

        .nav-link {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid transparent;
        }
        .nav-link:hover {
            transform: translateX(4px);
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
        }

        /* Admin Active State (Indigo Aura) */
        .admin-active {
            background: rgba(99, 102, 241, 0.12) !important;
            border: 1px solid rgba(99, 102, 241, 0.3) !important;
            color: #c7d2fe !important;
            position: relative;
            box-shadow: 0 0 20px rgba(99, 102, 241, 0.1);
        }
        .admin-active::before {
            content: "";
            position: absolute;
            left: -1px;
            top: 20%;
            height: 60%;
            width: 4px;
            background: #818cf8;
            border-radius: 0 4px 4px 0;
            box-shadow: 0 0 15px rgba(99, 102, 241, 0.8);
        }

        /* Supplier Active State (Emerald Aura) */
        .supplier-active {
            background: rgba(16, 185, 129, 0.1) !important;
            border: 1px solid rgba(16, 185, 129, 0.3) !important;
            color: #a7f3d0 !important;
            position: relative;
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.1);
        }
        .supplier-active::before {
            content: "";
            position: absolute;
            left: -1px;
            top: 20%;
            height: 60%;
            width: 4px;
            background: #10b981;
            border-radius: 0 4px 4px 0;
            box-shadow: 0 0 15px rgba(16, 185, 129, 0.8);
        }

        .profile-card-glow {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(157, 26, 208, 0.08);
            box-shadow: inset 0 1px 1px rgba(255, 255, 255, 0.05);
        }

        .glass-header {
            background: linear-gradient(
                90deg,
                rgba(2, 6, 23, 0.95) 0%,
                rgba(15, 23, 42, 0.92) 40%,
                rgba(79, 70, 229, 0.10) 100%
            );
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            position: relative;
            overflow: hidden;
        }

        /* subtle animated glow line */
        .glass-header::before {
            content: "";
            position: absolute;
            top: 0;
            left: -50%;
            width: 200%;
            height: 2px;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(99, 102, 241, 0.6),
                transparent
            );
            animation: scanline 6s linear infinite;
        }

        @keyframes scanline {
            0% { transform: translateX(0); }
            100% { transform: translateX(50%); }
        }

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #475569; }
    </style>
</head>
<body class="antialiased overflow-hidden">
    <div class="flex h-screen overflow-hidden">
        
        <aside class="w-72 sidebar-premium flex flex-col p-6 overflow-y-auto">
            <div class="sidebar-glow"></div>
            
            <div class="nav-content flex flex-col h-full">
                <div class="mb-12 px-2">
                    <div class="flex items-center gap-4 group">
                        <div class="w-11 h-11 bg-[#1a1d26] border border-white/10 rounded-2xl flex items-center justify-center shadow-xl group-hover:border-indigo-500/50 transition-all duration-500">
                            <span class="text-xl transform group-hover:rotate-12 transition-transform">📦</span>
                        </div>
                        <div>
                            <h1 class="text-white font-black text-lg tracking-tighter italic uppercase">
                                Supply<span class="text-indigo-400">Mgr</span>
                            </h1>
                            <div class="h-[1px] w-full bg-gradient-to-r from-indigo-500/50 via-white/10 to-transparent mt-1"></div>
                        </div>
                    </div>
                </div>

                <nav class="flex-1 space-y-2">
                    @if(Auth::user()->role === 'admin')
                        <p class="text-[9px] font-black text-slate-500 uppercase tracking-[0.4em] px-4 mb-4">Command Center</p>
                        
                        <a href="{{ route('dashboard') }}" class="nav-link flex items-center gap-3 px-4 py-3.5 rounded-2xl {{ request()->routeIs('dashboard') ? 'admin-active' : 'text-slate-400 hover:text-white' }}">
                            <span class="text-lg">📊</span>
                            <span class="font-bold text-sm tracking-tight">Dashboard</span>
                        </a>

                        <a href="{{ route('admin.suppliers.index') }}" class="nav-link flex items-center gap-3 px-4 py-3.5 rounded-2xl {{ request()->routeIs('admin.suppliers.*') ? 'admin-active' : 'text-slate-400 hover:text-white' }}">
                            <span class="text-lg">👥</span>
                            <span class="font-bold text-sm tracking-tight">Suppliers</span>
                        </a>

                        <a href="{{ route('admin.orders.index') }}" class="nav-link flex items-center gap-3 px-4 py-3.5 rounded-2xl {{ request()->routeIs('admin.orders.*') ? 'admin-active' : 'text-slate-400 hover:text-white' }}">
                            <span class="text-lg">📦</span>
                            <span class="font-bold text-sm tracking-tight">Orders</span>
                        </a>

                        <a href="#" class="nav-link flex items-center gap-3 px-4 py-3.5 rounded-2xl text-slate-400 hover:text-white">
                            <span class="text-lg">📈</span>
                            <span class="font-bold text-sm tracking-tight">Reports</span>
                        </a>

                        <a href="{{ route('profile.edit') }}" class="nav-link flex items-center gap-3 px-4 py-3.5 rounded-2xl text-slate-400 hover:text-white">
                            <span class="text-lg">⚙️</span>
                            <span class="font-bold text-sm tracking-tight">Settings</span>
                        </a>

                    @elseif(Auth::user()->role === 'supplier')
                        <p class="text-[9px] font-black text-emerald-500/80 uppercase tracking-[0.4em] px-4 mb-4">Supplier Node</p>
                        
                        <a href="{{ route('dashboard') }}" class="nav-link flex items-center gap-3 px-4 py-3.5 rounded-2xl {{ request()->routeIs('dashboard') ? 'supplier-active' : 'text-slate-400 hover:text-white' }}">
                            <span class="text-lg">🏠</span>
                            <span class="font-bold text-sm tracking-tight">Dashboard</span>
                        </a>

                        <a href="{{ route('supplier.orders.index') }}" class="nav-link flex items-center gap-3 px-4 py-3.5 rounded-2xl {{ request()->routeIs('supplier.orders.*') ? 'supplier-active' : 'text-slate-400 hover:text-white' }}">
                            <span class="text-lg">📝</span>
                            <span class="font-bold text-sm tracking-tight">Orders</span>
                        </a>

                        <a href="#" class="nav-link flex items-center gap-3 px-4 py-3.5 rounded-2xl text-slate-400 hover:text-white">
                            <span class="text-lg">🧾</span>
                            <span class="font-bold text-sm tracking-tight">Invoices</span>
                        </a>

                        <a href="#" class="nav-link flex items-center gap-3 px-4 py-3.5 rounded-2xl text-slate-400 hover:text-white">
                            <span class="text-lg">📦</span>
                            <span class="font-bold text-sm tracking-tight">Products</span>
                        </a>

                        <a href="{{ route('profile.edit') }}" class="nav-link flex items-center gap-3 px-4 py-3.5 rounded-2xl {{ request()->routeIs('profile.edit') ? 'supplier-active' : 'text-slate-400 hover:text-white' }}">
                            <span class="text-lg">👤</span>
                            <span class="font-bold text-sm tracking-tight">Profile</span>
                        </a>
                    @endif
                </nav>

                <div class="mt-auto pt-6 border-t border-white/5">
                    <div class="p-4 rounded-[24px] profile-card-glow flex items-center gap-3 mb-4 transition-all hover:border-white/20">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-600 to-indigo-900 flex items-center justify-center text-[10px] font-black text-white border border-white/20 shadow-lg">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                        <div class="truncate">
                            <p class="text-xs font-bold text-white truncate">{{ Auth::user()->name }}</p>
                            <p class="text-[9px] text-indigo-300 font-black uppercase tracking-widest mt-0.5">Verified User</p>
                        </div>
                    </div>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-center text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 hover:text-red-400 transition-colors duration-300 py-2">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="h-20 flex items-center justify-between px-10 glass-header">
                <div>
                    <h2 class="text-xl font-black text-white tracking-tighter uppercase italic">
                        {{ $header ?? 'Ecosystem Overview' }}
                    </h2>
                </div>

                <div class="flex items-center gap-4">
                    <div class="h-8 w-[1px] bg-white/10 mx-2"></div>
                    <div class="flex flex-col items-end">
                        <span class="text-xs font-black text-white">{{ Auth::user()->name }}</span>
                        <span class="text-[9px] font-bold text-indigo-400 uppercase tracking-widest">{{ Auth::user()->role }}</span>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-10 bg-[#06070a]">
                <div class="max-w-7xl mx-auto">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</body>
</html>