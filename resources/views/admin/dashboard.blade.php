<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="h-6 w-1 bg-[#5046e5] rounded-full shadow-[0_0_15px_rgba(80,70,229,0.8)]"></div>
            <h2 class="text-2xl font-bold text-white tracking-tight">
                System <span class="text-[#5046e5] font-medium italic">Intelligence</span>
            </h2>
        </div>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @php
        $stats = $adminStats ?? [];
        $weekly = array_values($weeklyOrders ?? [0,0,0,0,0,0,0]);
        $chart = array_values($chartData ?? [0,0,0]); // Assuming: [Success/Active, Pending/Warning, Failed/Critical]
    @endphp

    <style>
        .glass-card {
            background: linear-gradient(145deg, rgba(27, 25, 49, 0.4) 0%, rgba(13, 11, 26, 0.4) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .glass-card:hover {
            border-color: rgba(80, 70, 229, 0.3);
            transform: translateY(-2px);
        }
        .activity-row:hover {
            background: rgba(255, 255, 255, 0.02);
        }
    </style>

    <div class="py-8 space-y-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- KPI CARDS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $cards = [
                    [
                        'label' => 'Total Suppliers',
                        'val' => data_get($stats, 'total_suppliers', 0),
                        'color' => '#6366f1',
                        'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'
                    ],
                    [
                        'label' => 'Active Orders',
                        'val' => data_get($stats, 'active_orders', 0),
                        'color' => '#10b981',
                        'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'
                    ],
                    [
                        'label' => 'Pending Approvals',
                        'val' => data_get($stats, 'pending_approvals', 0),
                        'color' => '#a855f7',
                        'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
                    ],
                ];
            @endphp

            @foreach($cards as $card)
                <div class="glass-card relative p-8 rounded-[2.2rem] shadow-2xl group overflow-hidden">
                    <div class="absolute -top-12 -right-12 w-32 h-32 blur-[50px] opacity-20 group-hover:opacity-40 transition-opacity"
                         style="background-color: {{ $card['color'] }}"></div>

                    <div class="relative z-10 flex justify-between items-start">
                        <div>
                            <p class="text-slate-500 text-[10px] font-bold uppercase tracking-[0.2em]">
                                {{ $card['label'] }}
                            </p>
                            <h3 class="text-4xl font-black text-white mt-3 tracking-tighter">
                                {{ number_format($card['val']) }}
                            </h3>
                        </div>
                        <div class="p-3 rounded-2xl bg-[#0d0b1a] border border-white/5 text-white/50 group-hover:text-white transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $card['icon'] }}" />
                            </svg>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- CHARTS SECTION --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- WEEKLY FLOW --}}
            <div class="lg:col-span-2 glass-card rounded-[2.5rem] p-8">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-white font-bold text-lg tracking-tight">Weekly Orders Flow</h3>
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-[#5046e5] animate-pulse"></span>
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Live Feed</span>
                    </div>
                </div>
                <div class="h-72">
                    <canvas id="velocityChart"></canvas>
                </div>
            </div>

            {{-- SYSTEM HEALTH WITH INDICATORS --}}
            <div class="glass-card rounded-[2.5rem] p-8 flex flex-col items-center">
                <h3 class="text-white font-bold text-lg mb-4 tracking-tight">System Health</h3>
                
                <div class="relative w-52 h-52 flex items-center justify-center mb-6">
                    <canvas id="statusChart"></canvas>
                    <div class="absolute text-center">
                        <div class="text-4xl font-black text-white tracking-tighter">
                            {{ array_sum($chart) }}
                        </div>
                        <div class="text-[9px] text-slate-500 font-bold uppercase tracking-widest">Total Assets</div>
                    </div>
                </div>

                {{-- Legend / Indicators --}}
                <div class="w-full space-y-3 px-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)] animate-pulse"></span>
                            <span class="text-[10px] font-bold text-slate-300 uppercase tracking-wider">Success</span>
                        </div>
                        <span class="text-[10px] font-mono text-white/50 font-bold">{{ $chart[0] ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                            <span class="text-[10px] font-bold text-slate-300 uppercase tracking-wider">Warning</span>
                        </div>
                        <span class="text-[10px] font-mono text-white/50 font-bold">{{ $chart[1] ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                            <span class="text-[10px] font-bold text-slate-300 uppercase tracking-wider">Critical</span>
                        </div>
                        <span class="text-[10px] font-mono text-white/50 font-bold">{{ $chart[2] ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- RECENT ACTIVITY --}}
        <div class="glass-card rounded-[2.5rem] overflow-hidden">
            <div class="px-8 py-6 border-b border-white/5 flex items-center justify-between bg-white/[0.01]">
                <div>
                    <h3 class="text-white font-bold text-xl tracking-tight">Recent Activity</h3>
                    <p class="text-slate-500 text-[11px] mt-1 uppercase tracking-wider">System Event Stream</p>
                </div>

                <form method="POST" action="{{ route('admin.activity.clear') }}" onsubmit="return confirm('Clear activity log?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-xs font-medium text-rose-500/80 hover:text-rose-400 transition-colors flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        clear activity
                    </button>
                </form>
            </div>

            <div class="divide-y divide-white/5">
                @forelse($recentActivity as $order)
                    <div class="activity-row flex items-center justify-between p-6 transition-colors group">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-[#0d0b1a] border border-white/5 flex items-center justify-center text-[#5046e5] font-bold text-xs">
                                {{ strtoupper(substr($order->product_name, 0, 2)) }}
                            </div>
                            <div>
                                <p class="text-white font-bold text-sm tracking-tight group-hover:text-[#5046e5] transition-colors">
                                    {{ $order->product_name }}
                                </p>
                                <p class="text-[11px] text-slate-500 font-medium font-mono">
                                    #{{ $order->order_number }} • {{ $order->user->name ?? 'System' }}
                                </p>
                            </div>
                        </div>

                        <div class="text-right">
                            <div class="text-[10px] font-black uppercase tracking-widest mb-1
                                {{ $order->status == 'Delivered' ? 'text-emerald-400' : 'text-indigo-400' }}">
                                {{ $order->status }}
                            </div>
                            <p class="text-[10px] text-slate-600 font-bold uppercase">
                                {{ $order->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="py-16 text-center opacity-40">
                        <span class="text-slate-600 text-[10px] uppercase tracking-[0.3em] font-black">No active data detected</span>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Velocity Line Chart
            new Chart(document.getElementById('velocityChart'), {
                type: 'line',
                data: {
                    labels: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
                    datasets: [{
                        data: @json($weekly),
                        borderColor: '#5046e5',
                        backgroundColor: (context) => {
                            const {ctx, chartArea} = context.chart;
                            if (!chartArea) return null;
                            const gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
                            gradient.addColorStop(0, 'transparent');
                            gradient.addColorStop(1, 'rgba(80,70,229,0.15)');
                            return gradient;
                        },
                        fill: true,
                        tension: 0.45,
                        borderWidth: 4,
                        pointRadius: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { display: false },
                        x: { grid: { display: false }, ticks: { color: '#475569', font: { size: 10, weight: 'bold' } } }
                    }
                }
            });

            // Status Doughnut Chart
            new Chart(document.getElementById('statusChart'), {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: @json($chart),
                        backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
                        borderWidth: 0,
                        hoverOffset: 12
                    }]
                },
                options: {
                    cutout: '88%',
                    plugins: { legend: { display: false } }
                }
            });
        });
    </script>
</x-app-layout>