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
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #030406; 
            color: #f1f5f9;
            letter-spacing: -0.01em;
            overflow: hidden;
        }

        .app-shell {
            display: flex;
            height: 100vh;
            width: 100vw;
        }

        /* SIDEBAR: Enhanced Violet Glow */
        .sidebar-premium {
            background: 
                radial-gradient(circle at 0% 0%, rgba(139, 92, 246, 0.15) 0%, transparent 50%),
                linear-gradient(180deg, #12141c 0%, #08090d 100%);
            border-right: 1px solid rgba(139, 92, 246, 0.15);
            box-shadow: 10px 0 50px rgba(0,0,0,0.8);
            z-index: 30;
        }

        /* MAIN PANEL: Deeper Violet Accents */
        .main-content-area {
            background: 
                radial-gradient(circle at 100% 0%, rgba(139, 92, 246, 0.18) 0%, transparent 40%),
                radial-gradient(circle at 0% 100%, rgba(99, 102, 241, 0.08) 0%, transparent 30%),
                #050608;
            position: relative;
            z-index: 10;
        }

        .nav-link { 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
            color: #94a3b8; 
            border-radius: 12px; 
            margin-bottom: 4px;
        }
        
        .nav-link:hover { 
            color: #fff; 
            background: rgba(139, 92, 246, 0.08); 
            transform: translateX(4px);
        }

        .nav-active {
            background: rgba(139, 92, 246, 0.15) !important;
            color: #c4b5fd !important;
            font-weight: 600;
            box-shadow: inset 0 0 20px rgba(139, 92, 246, 0.05);
        }

        .glass-header {
            background: rgba(5, 6, 8, 0.8);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(139, 92, 246, 0.1);
        }

        /* FIXED NOTIFICATION PORTAL */
        .dropdown-portal {
            position: fixed;
            top: 80px;
            right: 40px;
            width: 360px;
            background: rgba(13, 14, 20, 0.95);
            backdrop-filter: blur(40px);
            border: 1px solid rgba(139, 92, 246, 0.3);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), 0 0 30px rgba(139, 92, 246, 0.1);
            border-radius: 20px;
            z-index: 9999 !important;
        }

        .notif-dot {
            position: absolute;
            top: 4px;
            right: 4px;
            width: 8px;
            height: 8px;
            background: #a78bfa;
            border-radius: 50%;
            box-shadow: 0 0 12px #8b5cf6;
        }
    </style>
</head>
<body class="antialiased" x-data="{ sidebarOpen: false, notificationsOpen: false }">
    <div class="app-shell">
        
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
               class="sidebar-premium w-72 flex flex-col p-6 fixed inset-y-0 left-0 lg:static lg:h-full transition-transform duration-300">
            <div class="flex flex-col h-full">
                <div class="mb-12 px-2">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-violet-500 to-indigo-600 rounded-xl flex items-center justify-center text-white shadow-[0_0_20px_rgba(139,92,246,0.3)]">
                            <span class="text-xl">📦</span>
                        </div>
                        <h1 class="text-white font-bold text-xl tracking-tighter">Supply<span class="text-violet-400">Manager</span></h1>
                    </div>
                </div>

                <nav class="flex-1 space-y-1 overflow-y-auto pr-2">
                    @php $isAdmin = Auth::user()->role === 'admin'; @endphp

                    <a href="{{ route('dashboard') }}" class="nav-link flex items-center gap-3 px-4 py-3.5 text-sm {{ request()->routeIs('dashboard') ? 'nav-active' : '' }}">
                        <span class="text-lg opacity-80">📊</span> Dashboard
                    </a>

                    @if($isAdmin)
                        <a href="{{ route('admin.suppliers.index') }}" class="nav-link flex items-center gap-3 px-4 py-3.5 text-sm {{ request()->routeIs('admin.suppliers.*') ? 'nav-active' : '' }}">
                            <span class="text-lg opacity-80">👥</span> Suppliers
                        </a>
                        <a href="#" class="nav-link flex items-center gap-3 px-4 py-3.5 text-sm">
                            <span class="text-lg opacity-80">📦</span> Product inventory
                        </a>
                        <a href="{{ route('admin.orders.index') }}" class="nav-link flex items-center gap-3 px-4 py-3.5 text-sm {{ request()->routeIs('admin.orders.*') ? 'nav-active' : '' }}">
                            <span class="text-lg opacity-80">📝</span> Order control
                        </a>
                        <a href="#" class="nav-link flex items-center gap-3 px-4 py-3.5 text-sm">
                            <span class="text-lg opacity-80">📈</span> System reports
                        </a>
                    @endif

                    <a href="{{ route('profile.edit') }}" class="nav-link flex items-center gap-3 px-4 py-3.5 text-sm {{ request()->routeIs('profile.*') ? 'nav-active' : '' }}">
                        <span class="text-lg opacity-80">⚙️</span> Settings
                    </a>
                </nav>

                <div class="mt-auto pt-6 border-t border-white/5">
                    <div class="p-4 rounded-2xl bg-violet-500/5 border border-violet-500/10">
                        <p class="text-xs font-bold text-white mb-0.5">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] text-violet-400/70 font-medium">Node: {{ Auth::user()->role }}</p>
                        <form method="POST" action="{{ route('logout') }}" class="mt-4">
                            @csrf
                            <button class="w-full py-2 text-[11px] font-bold text-slate-500 hover:text-violet-400 transition-colors">
                                Disconnect
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden main-content-area">
            <header class="h-20 flex items-center justify-between px-6 lg:px-12 glass-header shrink-0">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="lg:hidden text-slate-400 hover:text-violet-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <h2 class="text-sm font-semibold text-slate-300">{{ $header ?? 'Ecosystem overview' }}</h2>
                </div>

                <div class="flex items-center gap-8">
                    <button @click="notificationsOpen = !notificationsOpen" class="relative p-2 text-slate-400 hover:text-violet-400 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0" stroke-linecap="round"></path>
                        </svg>
                        <span class="notif-dot"></span>
                    </button>

                    <a href="{{ route('profile.edit') }}" class="w-10 h-10 rounded-xl bg-violet-500/10 flex items-center justify-center text-violet-400 border border-violet-500/20 hover:border-violet-500/50 transition-all">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    </a>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6 lg:p-10">
                <div class="max-w-7xl mx-auto">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    <div x-show="notificationsOpen" 
         @click.away="notificationsOpen = false" 
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         class="dropdown-portal">
        <div class="px-6 py-5 border-b border-white/5 bg-white/[0.02]">
            <h3 class="text-xs font-bold text-white">System Activity</h3>
        </div>
        <div class="max-h-96 overflow-y-auto">
            <div class="px-6 py-5 hover:bg-violet-500/5 border-b border-white/5 transition-colors cursor-pointer group">
                <p class="text-xs font-bold text-violet-300">Supplier update</p>
                <p class="text-[11px] text-slate-400 mt-1 leading-relaxed">Inventory sync successful for Node-B.</p>
                <p class="text-[9px] text-slate-600 mt-3 font-bold">Just now</p>
            </div>
        </div>
        <div class="p-4">
            <button class="w-full py-3 rounded-xl bg-white/[0.05] text-[10px] font-bold text-slate-400 hover:text-white transition-all">
                Dismiss all
            </button>
        </div>
    </div>
</body>
</html>