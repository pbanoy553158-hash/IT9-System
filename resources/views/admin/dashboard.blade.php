<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="h-6 w-1 bg-indigo-500 rounded-full shadow-[0_0_15px_rgba(99,102,241,0.6)]"></div>
            <h2 class="text-2xl font-bold text-white tracking-tight">
                System <span class="text-indigo-400 font-medium">Intelligence</span>
            </h2>
        </div>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="py-6 space-y-10">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @php
                $stats = [
                    ['label' => 'Total Suppliers', 'val' => $adminStats['total_suppliers'], 'color' => 'indigo', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                    ['label' => 'Active Orders', 'val' => $adminStats['active_orders'], 'color' => 'emerald', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                    ['label' => 'Total Revenue', 'val' => '₱'.number_format($adminStats['total_revenue'] / 1000, 1).'k', 'color' => 'orange', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1'],
                    ['label' => 'Pending Approvals', 'val' => $adminStats['pending_approvals'], 'color' => 'purple', 'icon' => 'M9 12l2 2 4-4'],
                ];
            @endphp

            @foreach($stats as $stat)
            <div class="group relative p-6 rounded-[2.5rem] bg-[#111319]/80 border border-white/[0.05] hover:border-{{ $stat['color'] }}-500/50 transition-all duration-500 shadow-2xl overflow-hidden">
                <div class="absolute -top-24 -right-24 w-48 h-48 bg-{{ $stat['color'] }}-500/10 blur-[60px] group-hover:bg-{{ $stat['color'] }}-500/20 transition-all duration-500"></div>
                
                <div class="flex justify-between items-start relative z-10">
                    <div>
                        <p class="text-slate-400 text-sm font-medium">{{ $stat['label'] }}</p>
                        <h3 class="text-4xl font-bold text-white mt-2 tracking-tighter">{{ $stat['val'] }}</h3>
                    </div>
                    <div class="p-4 bg-{{ $stat['color'] }}-500/10 text-{{ $stat['color'] }}-400 rounded-2xl group-hover:rotate-6 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/></svg>
                    </div>
                </div>
                
                <div class="mt-8 flex items-center gap-2">
                    <div class="h-1.5 w-1.5 rounded-full bg-{{ $stat['color'] }}-500 animate-pulse"></div>
                    <span class="text-xs font-medium text-slate-500">Live network updates</span>
                </div>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 bg-[#0d0f14] border border-white/[0.03] rounded-[3rem] p-10 shadow-3xl relative overflow-hidden">
                <div class="flex justify-between items-center mb-10">
                    <div>
                        <h3 class="text-white font-bold text-2xl tracking-tight">Recent Activity</h3>
                        <p class="text-slate-500 text-sm mt-1">Latest logistical updates across the platform</p>
                    </div>
                    <a href="{{ route('admin.orders.index') }}" class="px-5 py-2 bg-white/5 hover:bg-indigo-500/10 rounded-full text-xs text-indigo-400 font-semibold transition-all">View all history</a>
                </div>

                <div class="space-y-4">
                    @forelse($recentActivity as $order)
                    <div class="group flex items-center gap-6 p-5 rounded-[2rem] hover:bg-white/[0.02] border border-transparent hover:border-white/5 transition-all duration-300">
                        <div class="w-14 h-14 bg-[#161821] rounded-2xl flex items-center justify-center text-2xl shadow-inner group-hover:scale-105 transition-transform">
                            {{ $order->status === 'Delivered' ? '✅' : '📦' }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-white font-semibold text-lg leading-tight truncate">{{ $order->product_name }}</h4>
                            <p class="text-slate-500 text-sm mt-1">Order {{ $order->order_number }} • <span class="text-indigo-400/80">{{ $order->user->name }}</span></p>
                        </div>
                        <div class="text-right shrink-0">
                            <span class="px-4 py-1.5 rounded-full text-[11px] font-semibold tracking-wide {{ $order->status === 'Delivered' ? 'bg-emerald-500/10 text-emerald-400' : 'bg-indigo-500/10 text-indigo-400' }}">
                                {{ $order->status }}
                            </span>
                            <p class="text-slate-600 text-xs font-medium mt-2">{{ $order->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="py-20 text-center">
                        <p class="text-slate-500 font-medium text-sm">No recent activity detected.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <div class="bg-gradient-to-br from-[#161821] to-[#0d0f14] border border-white/5 rounded-[3rem] p-10 flex flex-col items-center shadow-3xl overflow-hidden relative">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-indigo-500 to-transparent opacity-40"></div>
                
                <h3 class="text-white font-bold text-xl mb-1 tracking-tight">System Integrity</h3>
                <p class="text-slate-500 text-sm font-medium mb-8">Overall health metric</p>

                <div class="relative w-full aspect-square flex items-center justify-center mb-10">
                    <div class="absolute inset-0 bg-indigo-500/5 blur-[80px] rounded-full"></div>
                    <canvas id="statusChart"></canvas>
                    <div class="absolute flex flex-col items-center">
                        <span class="text-5xl font-black text-white tracking-tighter">99<span class="text-indigo-500 text-3xl">.4</span></span>
                        <span class="text-xs text-slate-500 font-bold mt-1 tracking-widest">Efficiency</span>
                    </div>
                </div>

                <div class="w-full space-y-6">
                    <div class="space-y-2">
                        <div class="flex justify-between items-end">
                            <span class="text-xs font-semibold text-slate-500">Current network load</span>
                            <span class="text-xs font-bold text-white">65%</span>
                        </div>
                        <div class="w-full h-1.5 bg-white/5 rounded-full overflow-hidden">
                            <div class="h-full bg-indigo-500 rounded-full" style="width: 65%"></div>
                        </div>
                    </div>
                    
                    <button class="w-full py-4 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-bold rounded-2xl shadow-[0_20px_40px_rgba(79,70,229,0.3)] transition-all active:scale-95">
                        Generate Performance Report
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('statusChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode(array_keys($chartData)) !!},
                    datasets: [{
                        data: {!! json_encode(array_values($chartData)) !!},
                        backgroundColor: [
                            '#6366f1', '#10b981', '#f59e0b', '#8b5cf6', '#ef4444'
                        ],
                        hoverOffset: 15,
                        borderWidth: 0,
                        borderRadius: 15,
                        spacing: 8
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    cutout: '88%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0d0f14',
                            titleFont: { size: 14, weight: 'bold' },
                            bodyFont: { size: 13 },
                            padding: 12,
                            cornerRadius: 12,
                            displayColors: false
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>