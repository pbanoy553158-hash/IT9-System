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

        $chart = array_values($chartData ?? [0,0,0]);
    @endphp

    <div class="py-8 space-y-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- KPI CARDS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            @php
                $cards = [
                    [
                        'label' => 'Total Suppliers',
                        'val' => data_get($stats, 'total_suppliers', 0),
                        'color' => '#6366f1'
                    ],
                    [
                        'label' => 'Active Orders',
                        'val' => data_get($stats, 'active_orders', 0),
                        'color' => '#10b981'
                    ],
                    [
                        'label' => 'Pending Approvals',
                        'val' => data_get($stats, 'pending_approvals', 0),
                        'color' => '#a855f7'
                    ],
                ];
            @endphp

            @foreach($cards as $card)
                <div class="relative p-8 rounded-[2.2rem] bg-[#0f1116] border border-white/10 hover:border-white/20 transition shadow-2xl overflow-hidden group">
                    <div class="absolute -top-10 -right-10 w-40 h-40 blur-[60px] opacity-10 group-hover:opacity-20"
                         style="background-color: {{ $card['color'] }}"></div>

                    <p class="text-slate-400 text-[10px] uppercase tracking-[0.2em]">
                        {{ $card['label'] }}
                    </p>

                    <h3 class="text-4xl font-black text-white mt-3">
                        {{ $card['val'] }}
                    </h3>
                </div>
            @endforeach

        </div>

        {{-- CHARTS --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- WEEKLY --}}
            <div class="lg:col-span-2 bg-[#0d0f14] border border-white/10 rounded-[2.5rem] p-8">
                <h3 class="text-white font-bold text-lg mb-6">Weekly Orders Flow</h3>
                <div class="h-72">
                    <canvas id="velocityChart"></canvas>
                </div>
            </div>

            {{-- SYSTEM HEALTH --}}
            <div class="bg-[#0d0f14] border border-white/10 rounded-[2.5rem] p-8 flex flex-col items-center">
                <h3 class="text-white font-bold text-lg mb-4">System Health</h3>

                <div class="relative w-52 h-52 flex items-center justify-center">
                    <canvas id="statusChart"></canvas>

                    <div class="absolute text-center">
                        <div class="text-4xl font-black text-white">
                            {{ array_sum($chart) }}
                        </div>
                        <div class="text-[10px] text-slate-400 uppercase">Total Status</div>
                    </div>
                </div>
            </div>

        </div>

        {{-- RECENT ACTIVITY --}}
        <div class="bg-[#0d0f14] border border-white/10 rounded-[3rem] p-8">

            <h3 class="text-white font-bold text-xl mb-6">Recent Activity</h3>

            <div class="space-y-3">
                @forelse($recentActivity as $order)
                    <div class="flex items-center justify-between p-4 rounded-2xl bg-white/5 border border-white/5">

                        <div>
                            <p class="text-white font-semibold">
                                {{ $order->product_name }}
                            </p>

                            <p class="text-xs text-slate-400">
                                #{{ $order->order_number }} • {{ $order->user->name ?? 'System' }}
                            </p>
                        </div>

                        <div class="text-right">
                            <div class="text-xs font-bold uppercase
                                {{ $order->status == 'Delivered' ? 'text-emerald-400' : 'text-indigo-400' }}">
                                {{ $order->status }}
                            </div>

                            <p class="text-xs text-slate-500">
                                {{ $order->created_at->diffForHumans() }}
                            </p>
                        </div>

                    </div>
                @empty
                    <p class="text-slate-500 text-center py-6">No recent activity</p>
                @endforelse
            </div>

        </div>
    </div>

    {{-- CHART SCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            new Chart(document.getElementById('velocityChart'), {
                type: 'line',
                data: {
                    labels: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
                    datasets: [{
                        data: @json($weekly),
                        borderColor: '#5046e5',
                        backgroundColor: 'rgba(80,70,229,0.15)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        pointRadius: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } }
                }
            });

            new Chart(document.getElementById('statusChart'), {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: @json($chart),
                        backgroundColor: ['#10b981','#f59e0b','#ef4444'],
                        borderWidth: 0
                    }]
                },
                options: {
                    cutout: '80%',
                    plugins: { legend: { display: false } }
                }
            });

        });
    </script>

</x-app-layout>