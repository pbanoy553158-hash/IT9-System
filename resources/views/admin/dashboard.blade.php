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
        $safeWeekly = $weeklyOrders ?? [0,0,0,0,0,0,0];
        $safeChart = array_values($chartData ?? [0,0,0]);
    @endphp

    <div class="py-8 space-y-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- 1. KPI CARDS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $cards = [
                    ['label' => 'Total Suppliers', 'val' => data_get($stats, 'total_suppliers', 0), 'color' => '#6366f1', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857'],
                    ['label' => 'Active Orders', 'val' => data_get($stats, 'active_orders', 0), 'color' => '#10b981', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                    ['label' => 'Pending Approvals', 'val' => data_get($stats, 'pending_approvals', 0), 'color' => '#a855f7', 'icon' => 'M9 12l2 2 4-4'],
                ];
            @endphp

            @foreach($cards as $card)
            <div class="relative p-8 rounded-[2.2rem] bg-[#0f1116] border border-white/10 hover:border-white/20 transition shadow-2xl overflow-hidden group">
                <div class="absolute -top-10 -right-10 w-40 h-40 blur-[60px] opacity-10 group-hover:opacity-20" style="background-color: {{ $card['color'] }}"></div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-400 text-[10px] uppercase tracking-[0.2em]">{{ $card['label'] }}</p>
                        <h3 class="text-4xl font-black text-white mt-3 tracking-tight">{{ $card['val'] }}</h3>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-white/5 flex items-center justify-center" style="color: {{ $card['color'] }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}" />
                        </svg>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- 2. CHARTS SECTION --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Weekly Flow --}}
            <div class="lg:col-span-2 bg-[#0d0f14] border border-white/10 rounded-[2.5rem] p-8 shadow-xl">
                <h3 class="text-white font-bold text-lg mb-6">Weekly Orders Flow</h3>
                <div class="h-72"><canvas id="velocityChart"></canvas></div>
            </div>

            {{-- System Health --}}
            <div class="bg-[#0d0f14] border border-white/10 rounded-[2.5rem] p-8 flex flex-col items-center shadow-2xl relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-44 h-44 bg-[#5046e5]/20 blur-3xl"></div>
                <h3 class="text-white font-bold text-lg tracking-tight mb-4">System Health</h3>
                <div class="relative w-52 h-52 flex items-center justify-center my-4">
                    <canvas id="statusChart"></canvas>
                    <div class="absolute flex flex-col items-center">
                        <div class="text-4xl font-black text-white leading-none">{{ array_sum($safeChart) }}</div>
                        <div class="text-[10px] text-slate-400 uppercase tracking-widest mt-2">Total Status</div>
                    </div>
                </div>
                <div class="flex gap-4 mt-4">
                    <div class="flex items-center gap-2 text-[10px] text-emerald-400 font-bold uppercase tracking-widest"><span class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_10px_rgba(16,185,129,0.6)]"></span> OK</div>
                    <div class="flex items-center gap-2 text-[10px] text-yellow-400 font-bold uppercase tracking-widest"><span class="w-2 h-2 rounded-full bg-yellow-500"></span> Warn</div>
                    <div class="flex items-center gap-2 text-[10px] text-red-400 font-bold uppercase tracking-widest"><span class="w-2 h-2 rounded-full bg-red-500"></span> Crit</div>
                </div>
            </div>
        </div> {{-- GRID ENDS HERE --}}

        {{-- 3. RECENT ACTIVITY (NOW FULL WIDTH) --}}
        <div class="w-full bg-[#0d0f14] border border-white/10 rounded-[3rem] p-8 shadow-2xl">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-white font-bold text-xl tracking-tight">Recent Activity</h3>
                <span class="text-[10px] text-slate-500 uppercase tracking-widest">Live Ledger</span>
            </div>

            <div class="space-y-3 w-full">
                @forelse($recentActivity as $order)
                <div class="group w-full flex items-center justify-between p-4 rounded-2xl bg-white/5 hover:bg-white/10 transition border border-white/5">
                    <div class="flex items-center gap-4 min-w-0 flex-1">
                        <div class="w-1.5 h-10 rounded-full {{ $order->status === 'Delivered' ? 'bg-emerald-500' : 'bg-[#5046e5]' }}"></div>
                        <div class="min-w-0 flex-1">
                            <p class="text-white font-semibold text-sm truncate group-hover:text-[#5046e5] transition">{{ $order->product_name }}</p>
                            <p class="text-[11px] text-slate-400 truncate">#{{ $order->order_number }} • {{ $order->user->name ?? 'System' }}</p>
                        </div>
                    </div>
                    <div class="text-right shrink-0">
                        <div class="text-[10px] font-bold uppercase tracking-widest {{ $order->status === 'Delivered' ? 'text-emerald-400' : 'text-indigo-400' }}">{{ $order->status }}</div>
                        <p class="text-[10px] text-slate-500 mt-1">{{ $order->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @empty
                <p class="text-center text-slate-500 py-8 text-sm w-full">No recent activity</p>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new Chart(document.getElementById('velocityChart'), {
                type: 'line',
                data: {
                    labels: ['MON','TUE','WED','THU','FRI','SAT','SUN'],
                    datasets: [{
                        data: @json($safeWeekly),
                        borderColor: '#5046e5',
                        backgroundColor: 'rgba(80,70,229,0.12)',
                        fill: true, tension: 0.4, borderWidth: 3, pointRadius: 0
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
            });

            new Chart(document.getElementById('statusChart'), {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: @json($safeChart),
                        backgroundColor: ['#10b981','#f59e0b','#ef4444'],
                        borderWidth: 0
                    }]
                },
                options: { cutout: '82%', plugins: { legend: { display: false } } }
            });
        });
    </script>
</x-app-layout>