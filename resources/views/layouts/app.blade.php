<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SupplyManager • Ecosystem</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

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

        .app-shell { display: flex; height: 100vh; width: 100vw; }

        /* UPGRADED: Mesh Gradient Background */
        .main-content-area {
            background-color: #050508;
            background-image: 
                radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(168, 85, 247, 0.1) 0px, transparent 50%),
                radial-gradient(at 50% 100%, rgba(67, 56, 202, 0.08) 0px, transparent 50%);
            position: relative;
        }

        /* UPGRADED: Frosted Sidebar */
        .sidebar-premium {
            background: rgba(13, 14, 20, 0.8);
            backdrop-filter: blur(12px);
            border-right: 1px solid rgba(255, 255, 255, 0.06);
            z-index: 50;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-link { 
            transition: all 0.2s ease; 
            color: #94a3b8; 
            border-radius: 14px;
            margin-bottom: 4px;
            position: relative;
        }

        .nav-link:hover { 
            color: #fff; 
            background: rgba(255, 255, 255, 0.05); 
            transform: translateX(4px);
        }

        /* UPGRADED: Glow effect for active links */
        .nav-active {
            background: linear-gradient(90deg, rgba(99, 102, 241, 0.15) 0%, rgba(99, 102, 241, 0.03) 100%) !important;
            color: #c7d2fe !important;
            font-weight: 700;
            box-shadow: inset 2px 0 0 #6366f1;
        }

        .glass-header {
            background: rgba(5, 5, 8, 0.7);
            backdrop-filter: blur(24px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); border-radius: 10px; }

        /* UPGRADED: Pulsing Notification Dot */
        .notif-dot {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 8px;
            height: 8px;
            background: #6366f1;
            border-radius: 50%;
            border: 2px solid #08090d;
            box-shadow: 0 0 10px rgba(99, 102, 241, 0.6);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.2); opacity: 0.7; }
            100% { transform: scale(1); opacity: 1; }
        }

        /* Card stylings for inside the $slot */
        .premium-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 24px;
        }
    </style>
</head>
<body class="antialiased" 
      x-data="{ 
          sidebarOpen: false, 
          notificationsOpen: false 
      }">

    <div class="app-shell">
        
        {{-- SIDEBAR --}}
        @php 
            $isAdmin = Auth::user()->role === 'admin'; 
            $sidebarWidth = $isAdmin ? 'w-72' : 'w-64'; 
        @endphp

        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
               class="sidebar-premium {{ $sidebarWidth }} flex flex-col p-6 lg:p-8 fixed inset-y-0 left-0 lg:static lg:h-full">

            <div class="flex flex-col h-full">
                {{-- Logo with enhanced glow --}}
                <div class="mb-12 px-1 flex items-center gap-3 group cursor-default">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 via-violet-600 to-fuchsia-600 rounded-2xl flex items-center justify-center shadow-[0_0_20px_rgba(99,102,241,0.3)] group-hover:shadow-[0_0_25px_rgba(99,102,241,0.5)] transition-all duration-500">
                        <span class="text-xl">📦</span>
                    </div>
                    <div>
                        <h1 class="text-white font-bold text-[22px] tracking-tighter leading-none">
                            Supply<span class="bg-gradient-to-r from-slate-400 to-slate-100 bg-clip-text text-transparent font-medium">Manager</span>
                        </h1>
                    </div>
                </div>

                <nav class="flex-1 overflow-y-auto pr-2 custom-scrollbar">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-4 px-4">Menu</p>
                    
                    @if($isAdmin)
                        <a href="{{ route('dashboard') }}" class="nav-link flex items-center gap-4 px-5 py-3.5 text-sm {{ request()->routeIs('dashboard') ? 'nav-active' : '' }}">
                            <span class="opacity-80">🏠</span> 
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('admin.suppliers.index') }}" class="nav-link flex items-center gap-4 px-5 py-3.5 text-sm {{ request()->routeIs('admin.suppliers.*') ? 'nav-active' : '' }}">
                            <span class="opacity-80">👥</span> 
                            <span>Suppliers</span>
                        </a>
                        <a href="{{ route('admin.products.index') }}" class="nav-link flex items-center gap-4 px-5 py-3.5 text-sm {{ request()->routeIs('admin.products.*') ? 'nav-active' : '' }}">
                            <span class="opacity-80">📦</span> 
                            <span>Inventory</span>
                        </a>
                        <a href="{{ route('admin.orders.index') }}" class="nav-link flex items-center gap-4 px-5 py-3.5 text-sm {{ request()->routeIs('admin.orders.*') ? 'nav-active' : '' }}">
                            <span class="opacity-80">📝</span> 
                            <span>Orders</span>
                        </a>
                        <a href="{{ route('admin.reports.index') }}" class="nav-link flex items-center gap-4 px-5 py-3.5 text-sm {{ request()->routeIs('admin.reports.*') ? 'nav-active' : '' }}">
                            <span class="opacity-80">📊</span> 
                            <span>Reports</span>
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="nav-link flex items-center gap-3 px-4 py-3 text-sm {{ request()->routeIs('dashboard') ? 'nav-active' : '' }}">
                            <span class="text-lg w-6">🏠</span> 
                            <span class="font-medium">Dashboard</span>
                        </a>
                        <a href="{{ route('supplier.products.index') }}" class="nav-link flex items-center gap-3 px-4 py-3 text-sm {{ request()->routeIs('supplier.products.*') ? 'nav-active' : '' }}">
                            <span class="text-lg w-6">📦</span> 
                            <span class="font-medium">Products</span>
                        </a>
                        <a href="{{ route('supplier.orders.index') }}" class="nav-link flex items-center gap-3 px-4 py-3 text-sm {{ request()->routeIs('supplier.orders.*') ? 'nav-active' : '' }}">
                            <span class="text-lg w-6">📝</span> 
                            <span class="font-medium">Orders</span>
                        </a>
                        <a href="{{ route('supplier.invoices.index') }}" class="nav-link flex items-center gap-3 px-4 py-3 text-sm {{ request()->routeIs('supplier.invoices.*') ? 'nav-active' : '' }}">
                            <span class="text-lg w-6">📄</span> 
                            <span class="font-medium">Invoices</span>
                        </a>
                    @endif

                    <div class="mt-10 pt-8 border-t border-white/5">
                        <a href="{{ route('profile.edit') }}" class="nav-link flex items-center gap-3 px-4 py-3 text-sm {{ request()->routeIs('profile.*') ? 'nav-active' : '' }}">
                            <span class="text-lg w-6">⚙️</span> 
                            <span class="font-medium">Settings</span>
                        </a>
                    </div>
                </nav>

                {{-- User Session Card - Modern Glass --}}
                <div class="mt-auto pt-8">
                    <div class="p-4 rounded-[24px] bg-gradient-to-b from-white/[0.05] to-transparent border border-white/10 shadow-2xl">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="relative">
                                @if(Auth::user()->profile_photo_path)
                                    <img src="/storage/{{ Auth::user()->profile_photo_path }}" 
                                         class="w-10 h-10 rounded-xl object-cover ring-2 ring-indigo-500/20">
                                @else
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center font-bold text-white text-sm shadow-inner">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                @endif
                                <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-emerald-500 border-[3px] border-[#0d0e14] rounded-full"></div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-white truncate">{{ Auth::user()->name }}</p>
                                <p class="text-[9px] text-indigo-400 font-black uppercase tracking-[0.15em]">{{ Auth::user()->role }}</p>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full py-2.5 bg-indigo-500/10 hover:bg-indigo-500 hover:text-white text-indigo-300 rounded-xl text-xs font-bold transition-all duration-300 border border-indigo-500/20">
                                Sign out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <div class="flex-1 flex flex-col overflow-hidden main-content-area">
            
            <header class="h-20 flex items-center justify-between px-8 lg:px-12 glass-header shrink-0">
                <div class="flex items-center gap-6">
                    <button @click="sidebarOpen = !sidebarOpen" 
                            class="lg:hidden p-2 text-slate-400 hover:text-white rounded-xl hover:bg-white/[0.05]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <h2 class="text-xl font-bold text-white tracking-tight">
                        {{ $header ?? 'Overview' }}
                    </h2>
                </div>

                <div class="flex items-center gap-4">
                    {{-- Search bar - Optional aesthetic addition --}}
                    <div class="hidden md:flex items-center bg-white/[0.03] border border-white/5 rounded-2xl px-4 py-2 w-64 focus-within:border-indigo-500/50 transition-all">
                        <span class="text-slate-500 text-sm">🔍</span>
                        <input type="text" placeholder="Search anything..." class="bg-transparent border-none text-xs text-slate-300 focus:ring-0 w-full placeholder:text-slate-600">
                    </div>

                    {{-- Bell Icon --}}
                    <button @click="notificationsOpen = !notificationsOpen" 
                            class="relative w-11 h-11 flex items-center justify-center text-slate-400 hover:text-white transition-all hover:bg-white/[0.08] rounded-2xl group border border-transparent hover:border-white/10">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                             class="w-5 h-5 transition-transform group-hover:rotate-12" 
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                             viewBox="0 0 24 24">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                            <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                        </svg>
                        <span class="notif-dot"></span>
                    </button>

                    <div class="h-8 w-[1px] bg-white/10 mx-2"></div>

                    {{-- Profile Icon --}}
                    <a href="{{ route('profile.edit') }}" class="group flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl overflow-hidden border border-white/10 group-hover:border-indigo-500/50 transition-all shadow-lg">
                            @if(Auth::user()->profile_photo_path)
                                <img src="/storage/{{ Auth::user()->profile_photo_path }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-indigo-600 to-violet-700 flex items-center justify-center text-white text-sm font-bold">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                    </a>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-8 lg:p-12 custom-scrollbar">
                <div class="max-w-7xl mx-auto">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    {{-- Notification Panel --}}
    <div x-show="notificationsOpen" 
         @click.away="notificationsOpen = false"
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95 translate-y-[-10px]"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         class="fixed top-20 right-6 lg:right-12 w-80 bg-[#0d0e14]/90 backdrop-blur-3xl border border-white/10 shadow-[0_20px_50px_rgba(0,0,0,0.5)] rounded-[32px] z-[9999] overflow-hidden">

        <div class="px-6 py-5 border-b border-white/5 flex items-center justify-between">
            <span class="text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em]">Notifications</span>
            <span class="bg-indigo-500/20 text-indigo-400 text-[10px] px-2 py-0.5 rounded-full font-bold">2 New</span>
        </div>
        
        <div class="max-h-[380px] overflow-y-auto custom-scrollbar p-3 space-y-2">
            <div class="p-4 rounded-2xl hover:bg-white/[0.04] transition-all cursor-pointer border border-transparent hover:border-white/5">
                <div class="flex gap-3">
                    <div class="w-2 h-2 mt-1.5 rounded-full bg-indigo-500 shadow-[0_0_8px_#6366f1]"></div>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-white">Your catalog is live</p>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">System has synced your latest inventory updates.</p>
                        <p class="text-[10px] text-slate-600 mt-3 font-medium">Just now</p>
                    </div>
                </div>
            </div>
            
            <div class="p-4 rounded-2xl hover:bg-white/[0.04] transition-all cursor-pointer border border-transparent hover:border-white/5">
                <div class="flex gap-3">
                    <div class="w-2 h-2 mt-1.5 rounded-full bg-indigo-500 shadow-[0_0_8px_#6366f1]"></div>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-white">New order #ORD-3921</p>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">12 items awaiting processing.</p>
                        <p class="text-[10px] text-slate-600 mt-3 font-medium">2 hours ago</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-4 border-t border-white/5 bg-white/[0.02]">
            <button @click="notificationsOpen = false"
                    class="w-full py-3 text-xs font-bold text-slate-400 hover:text-white hover:bg-white/5 rounded-2xl transition-all">
                Clear all notifications
            </button>
        </div>
    </div>
</body>
</html>