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

        .sidebar-premium {
            background: linear-gradient(180deg, #0d0e14 0%, #030406 100%);
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            z-index: 50;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .main-content-area {
            background: 
                radial-gradient(circle at 50% 0%, rgba(99, 102, 241, 0.08) 0%, transparent 50%),
                #08090d;
            position: relative;
        }

        .nav-link { 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
            color: #64748b; 
            border-radius: 16px;
            margin-bottom: 4px;
        }
        .nav-link:hover { 
            color: #fff; 
            background: rgba(255, 255, 255, 0.03); 
            transform: translateX(4px);
        }

        .nav-active {
            background: rgba(99, 102, 241, 0.1) !important;
            color: #a5b4fc !important;
            font-weight: 700;
        }

        .glass-header {
            background: rgba(8, 9, 13, 0.8);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.03);
        }

        .custom-scrollbar::-webkit-scrollbar { width: 3px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); border-radius: 10px; }

        .notif-dot {
            position: absolute;
            top: 7px;
            right: 7px;
            width: 7px;
            height: 7px;
            background: #6366f1;
            border-radius: 50%;
            border: 2px solid #08090d;
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
                {{-- Logo --}}
                <div class="mb-12 px-1 flex items-center gap-3 group cursor-default">
                    <div class="w-9 h-9 bg-gradient-to-br from-violet-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-violet-500/30 group-hover:scale-105 transition-transform">
                        <span class="text-2xl">📦</span>
                    </div>
                    <div>
                        <h1 class="text-white font-bold text-[22px] tracking-tighter leading-none">
                            Supply<span class="text-slate-400 font-medium">Manager</span>
                        </h1>
                    </div>
                </div>

                <nav class="flex-1 overflow-y-auto pr-2 custom-scrollbar">
                    @if($isAdmin)
                        {{-- Admin Sidebar --}}
                        <a href="{{ route('dashboard') }}" class="nav-link flex items-center gap-4 px-5 py-3.5 text-sm {{ request()->routeIs('dashboard') ? 'nav-active' : '' }}">
                            <span class="text-2xl">🏠</span> 
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('admin.suppliers.index') }}" class="nav-link flex items-center gap-4 px-5 py-3.5 text-sm {{ request()->routeIs('admin.suppliers.*') ? 'nav-active' : '' }}">
                            <span class="text-2xl">👥</span> 
                            <span>Suppliers</span>
                        </a>
                        <a href="{{ route('admin.products.index') }}" class="nav-link flex items-center gap-4 px-5 py-3.5 text-sm {{ request()->routeIs('admin.products.*') ? 'nav-active' : '' }}">
                            <span class="text-2xl">📦</span> 
                            <span>Inventory</span>
                        </a>
                        <a href="{{ route('admin.orders.index') }}" class="nav-link flex items-center gap-4 px-5 py-3.5 text-sm {{ request()->routeIs('admin.orders.*') ? 'nav-active' : '' }}">
                            <span class="text-2xl">📝</span> 
                            <span>Orders</span>
                        </a>
                        <a href="{{ route('admin.reports.index') }}" class="nav-link flex items-center gap-4 px-5 py-3.5 text-sm {{ request()->routeIs('admin.reports.*') ? 'nav-active' : '' }}">
                            <span class="text-2xl">📊</span> 
                            <span>Reports</span>
                        </a>
                    @else
                        {{-- Supplier Sidebar - Compact --}}
                        <a href="{{ route('dashboard') }}" class="nav-link flex items-center gap-3 px-4 py-3 text-sm {{ request()->routeIs('dashboard') ? 'nav-active' : '' }}">
                            <span class="text-xl w-6">🏠</span> 
                            <span class="font-medium">Dashboard</span>
                        </a>
                        <a href="{{ route('supplier.products.index') }}" class="nav-link flex items-center gap-3 px-4 py-3 text-sm {{ request()->routeIs('supplier.products.*') ? 'nav-active' : '' }}">
                            <span class="text-xl w-6">📦</span> 
                            <span class="font-medium">Products</span>
                        </a>
                        <a href="{{ route('supplier.orders.index') }}" class="nav-link flex items-center gap-3 px-4 py-3 text-sm {{ request()->routeIs('supplier.orders.*') ? 'nav-active' : '' }}">
                            <span class="text-xl w-6">📝</span> 
                            <span class="font-medium">Orders</span>
                        </a>
                        <a href="{{ route('supplier.invoices.index') }}" class="nav-link flex items-center gap-3 px-4 py-3 text-sm {{ request()->routeIs('supplier.invoices.*') ? 'nav-active' : '' }}">
                            <span class="text-xl w-6">📄</span> 
                            <span class="font-medium">Invoices</span>
                        </a>
                    @endif

                    <div class="mt-10 pt-8 border-t border-white/5">
                        <a href="{{ route('profile.edit') }}" class="nav-link flex items-center gap-3 px-4 py-3 text-sm {{ request()->routeIs('profile.*') ? 'nav-active' : '' }}">
                            <span class="text-xl w-6">⚙️</span> 
                            <span class="font-medium">Settings</span>
                        </a>
                    </div>
                </nav>

                {{-- User Session Card --}}
                <div class="mt-auto pt-8">
                    <div class="p-5 rounded-3xl bg-white/[0.02] border border-white/5">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="relative">
                                @if(Auth::user()->profile_photo_path)
                                    <img src="/storage/{{ Auth::user()->profile_photo_path }}" 
                                         class="w-9 h-9 rounded-2xl object-cover ring-1 ring-white/10">
                                @else
                                    <div class="w-9 h-9 rounded-2xl bg-gradient-to-tr from-indigo-500 to-violet-600 flex items-center justify-center font-bold text-white text-sm">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                @endif
                                <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-500 border-2 border-[#030406] rounded-full"></div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                                <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">{{ Auth::user()->role }}</p>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full py-2.5 bg-white/5 hover:bg-white/10 text-slate-400 hover:text-white rounded-2xl text-xs font-medium transition-all border border-white/5">
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
                    <p class="text-lg font-semibold text-white tracking-tight">{{ $header ?? 'Dashboard' }}</p>
                </div>

                <div class="flex items-center gap-6">
                    {{-- Nice Bell Icon --}}
                    <button @click="notificationsOpen = !notificationsOpen" 
                            class="relative w-11 h-11 flex items-center justify-center text-slate-400 hover:text-white transition-all hover:bg-white/[0.07] rounded-2xl group">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                             class="w-6 h-6 transition-transform group-hover:scale-110" 
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                             viewBox="0 0 24 24">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                            <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                        </svg>
                        <span class="notif-dot"></span>
                    </button>

                    {{-- Profile Icon --}}
                    <a href="{{ route('profile.edit') }}" class="group">
                        <div class="w-11 h-11 rounded-2xl overflow-hidden border-2 border-transparent group-hover:border-indigo-400/60 transition-all bg-white/[0.06] shadow-inner">
                            @if(Auth::user()->profile_photo_path)
                                <img src="/storage/{{ Auth::user()->profile_photo_path }}" class="w-full h-full object-cover rounded-2xl">
                            @else
                                <div class="w-full h-full bg-gradient-to-tr from-indigo-500 via-purple-500 to-violet-600 flex items-center justify-center text-white text-base font-bold">
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
         x-transition
         class="fixed top-20 right-6 lg:right-10 w-80 bg-[#0d0e14]/95 backdrop-blur-2xl border border-white/10 shadow-2xl rounded-3xl z-[9999] overflow-hidden">

        <div class="px-6 py-4 border-b border-white/5 flex items-center justify-between">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Notifications</span>
        </div>
        
        <div class="max-h-[340px] overflow-y-auto custom-scrollbar p-3 space-y-1">
            <div class="p-4 rounded-2xl hover:bg-white/[0.04] transition-all cursor-pointer">
                <p class="text-sm font-semibold text-white">Your catalog is now live</p>
                <p class="text-xs text-slate-500 mt-1">All products are visible to buyers.</p>
                <p class="text-[10px] text-slate-600 mt-3">Just now</p>
            </div>
            
            <div class="p-4 rounded-2xl hover:bg-white/[0.04] transition-all cursor-pointer">
                <p class="text-sm font-semibold text-white">New order received #ORD-3921</p>
                <p class="text-xs text-slate-500 mt-1">12 items • ₱48,750</p>
                <p class="text-[10px] text-slate-600 mt-3">2 hours ago</p>
            </div>
        </div>

        <div class="p-4 border-t border-white/5 bg-white/[0.015]">
            <button @click="notificationsOpen = false"
                    class="w-full py-3 text-xs font-semibold text-slate-400 hover:text-white hover:bg-white/5 rounded-2xl transition-colors">
                Mark all as read
            </button>
        </div>
    </div>
</body>
</html>