<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SupplyManager • Intelligent Supplier Ecosystem</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #020105; 
            overflow-x: hidden;
        }

        .mesh-gradient {
            background-image: 
                radial-gradient(at 0% 0%, rgba(79, 70, 229, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(124, 58, 237, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(192, 38, 211, 0.15) 0px, transparent 50%),
                radial-gradient(at 0% 100%, rgba(79, 70, 229, 0.15) 0px, transparent 50%);
        }

        .grid-overlay {
            background-image: linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px), 
                              linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        }

        .glass-card:hover {
            background: rgba(255, 255, 255, 0.07);
            border-color: rgba(99, 102, 241, 0.5);
            transform: translateY(-8px);
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.5), 0 0 20px rgba(99, 102, 241, 0.2);
        }

        .hero-glow {
            filter: blur(120px);
            pointer-events: none;
        }

        @keyframes pulse-slow {
            0%, 100% { opacity: 0.4; transform: scale(1); }
            50% { opacity: 0.7; transform: scale(1.1); }
        }
        .animate-pulse-slow { animation: pulse-slow 8s ease-in-out infinite; }

        .btn-primary {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }
        .btn-primary:hover::before { left: 100%; }
    </style>
</head>
<body class="text-slate-200 mesh-gradient">
    <div class="fixed inset-0 grid-overlay pointer-events-none"></div>

    <div class="fixed top-[-10%] left-[-10%] w-[40%] h-[40%] bg-indigo-600/20 hero-glow rounded-full animate-pulse-slow"></div>
    <div class="fixed bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-fuchsia-600/10 hero-glow rounded-full animate-pulse-slow" style="animation-delay: 2s;"></div>

    <nav class="fixed top-0 w-full z-[100] border-b border-white/5 bg-[#020105]/80 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            <div class="flex items-center gap-3 group cursor-pointer">
                <div class="w-10 h-10 bg-gradient-to-tr from-indigo-600 to-violet-500 rounded-xl flex items-center justify-center shadow-[0_0_20px_rgba(79,70,229,0.4)] group-hover:rotate-12 transition-transform duration-500">
                    <span class="text-2xl">📦</span>
                </div>
                <span class="text-2xl font-bold tracking-tighter text-white">Supply<span class="text-indigo-400">Manager</span></span>
            </div>

            <div class="hidden md:flex items-center gap-8 text-sm font-semibold tracking-wide text-slate-400">
                <a href="#features" class="hover:text-white transition-colors">Platform</a>
                <a href="#how" class="hover:text-white transition-colors">Workflow</a>
                <a href="#network" class="hover:text-white transition-colors">Network</a>
            </div>

            <div class="flex items-center gap-4">
                <a href="/login" class="btn-primary px-6 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-full text-sm font-bold shadow-lg shadow-indigo-500/20 flex items-center gap-2">
                    Login
                </a>
            </div>
        </div>
    </nav>

    <section class="relative pt-40 pb-20 px-6">
        <div class="max-w-7xl mx-auto text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-xs font-bold tracking-widest uppercase mb-8">
                Enterprise Supplier Management
            </div>
            
            <h1 class="text-5xl md:text-8xl font-extrabold text-white tracking-tightest leading-[1] mb-8">
                Supply Chain <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-b from-indigo-300 via-indigo-500 to-indigo-800">Without Friction.</span>
            </h1>
            
            <p class="text-lg md:text-xl text-slate-400 max-w-2xl mx-auto mb-12 leading-relaxed">
                A unified ecosystem for modern procurement. Control every supplier, track every invoice, and eliminate manual overhead with our high-performance system.
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-4 mb-24">
                <a href="/login" class="btn-primary px-10 py-4 bg-white text-black rounded-2xl font-bold text-lg hover:scale-105 flex items-center justify-center gap-2">
                    Dashboard
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
                <a href="#network" class="px-10 py-4 glass-card rounded-2xl font-bold text-lg text-white flex items-center justify-center">
                    Contact Admin
                </a>
            </div>

            <div class="relative max-w-6xl mx-auto">
                <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-fuchsia-500 rounded-[2rem] blur opacity-20"></div>
                <div class="relative bg-[#0a0a0f] rounded-[2rem] border border-white/10 overflow-hidden shadow-2xl">
                    <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&q=80&w=2000" alt="Dashboard" class="opacity-80">
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="py-32 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="max-w-2xl mb-20">
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">Designed for scale.</h2>
                <p class="text-slate-400 text-lg">Powerful features focused on removing the distance between you and your suppliers.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <div class="glass-card p-10 rounded-[2.5rem]">
                    <div class="mb-6 text-indigo-400 text-3xl">👤</div>
                    <h3 class="text-2xl font-bold text-white mb-4">Admin Sovereignty</h3>
                    <p class="text-slate-400 leading-relaxed">Absolute control over onboarding. No unauthorized entries, ensuring your supplier database remains pristine.</p>
                </div>
                <div class="glass-card p-10 rounded-[2.5rem]">
                    <div class="mb-6 text-fuchsia-400 text-3xl">📦</div>
                    <h3 class="text-2xl font-bold text-white mb-4">Instant Ledger</h3>
                    <p class="text-slate-400 leading-relaxed">Real-time invoice generation and order tracking. Synchronized data for seamless operations.</p>
                </div>
                <div class="glass-card p-10 rounded-[2.5rem]">
                    <div class="mb-6 text-emerald-400 text-3xl">📊</div>
                    <h3 class="text-2xl font-bold text-white mb-4">Deep Analytics</h3>
                    <p class="text-slate-400 leading-relaxed">Turn your procurement data into insights. Track supplier performance with automated reporting.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="how" class="py-32 px-6 bg-white/[0.02]">
        <div class="max-w-7xl mx-auto text-center mb-20">
            <h2 class="text-4xl md:text-5xl font-bold text-white">Three steps. Total control.</h2>
        </div>
        <div class="grid md:grid-cols-3 gap-12 max-w-5xl mx-auto">
            <div class="text-center">
                <div class="mx-auto mb-8 w-16 h-16 bg-indigo-600/20 border border-indigo-500/30 text-indigo-400 rounded-2xl flex items-center justify-center text-2xl font-bold">1</div>
                <h4 class="text-xl font-bold text-white mb-4">Admin Creates Account</h4>
                <p class="text-slate-400">Strict entry control ensures only verified partners join.</p>
            </div>
            <div class="text-center">
                <div class="mx-auto mb-8 w-16 h-16 bg-indigo-600/20 border border-indigo-500/30 text-indigo-400 rounded-2xl flex items-center justify-center text-2xl font-bold">2</div>
                <h4 class="text-xl font-bold text-white mb-4">Instant Access</h4>
                <p class="text-slate-400">Suppliers log into a dedicated, clean management portal.</p>
            </div>
            <div class="text-center">
                <div class="mx-auto mb-8 w-16 h-16 bg-indigo-600/20 border border-indigo-500/30 text-indigo-400 rounded-2xl flex items-center justify-center text-2xl font-bold">3</div>
                <h4 class="text-xl font-bold text-white mb-4">Seamless Trading</h4>
                <p class="text-slate-400">Manage orders and invoices with real-time accuracy.</p>
            </div>
        </div>
    </section>

    <section id="network" class="py-32 px-6">
        <div class="max-w-5xl mx-auto relative">
            <div class="absolute inset-0 bg-indigo-600 rounded-[3rem] blur-3xl opacity-10"></div>
            <div class="relative glass-card p-12 md:p-20 rounded-[3rem] text-center border-indigo-500/20">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-400 text-xs font-bold tracking-widest uppercase mb-8">
                    Supplier Registration
                </div>
                <h2 class="text-4xl md:text-6xl font-bold text-white mb-8">Ready to join the <br>network?</h2>
                <p class="text-slate-300 text-xl mb-12 max-w-2xl mx-auto">Registration is restricted to authorized partners. Reach out to our administration to activate your portal.</p>
                
                <div class="flex flex-wrap justify-center gap-6">
                    <a href="mailto:admin@supplymanager.local" class="btn-primary px-12 py-5 bg-white text-black rounded-2xl font-bold text-xl">Email Admin</a>
                    <a href="tel:+639123456789" class="px-12 py-5 border border-white/20 hover:bg-white/5 rounded-2xl font-bold text-xl text-white transition-all">Direct Line</a>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-20 px-6 border-t border-white/5 bg-black/50">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-12">
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-xl">📦</div>
                    <span class="text-xl font-bold text-white">SupplyManager</span>
                </div>
                <p class="text-slate-500 text-sm">Empowering procurement teams everywhere.</p>
            </div>
            
            <div class="flex flex-col items-center md:items-end gap-2">
                <p class="text-slate-400 font-medium">© 2026 Princess Mae T. Banoy</p>
                <div class="flex gap-6 text-xs text-slate-500 uppercase tracking-widest">
                </div>
            </div>
        </div>
    </footer>
</body>
</html>