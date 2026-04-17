<x-app-layout>
    <x-slot name="header">
        <span class="text-indigo-400 font-medium">Dashboard</span> Overview
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="py-2">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="group p-6 rounded-3xl bg-[#1a1c26]/50 border border-white/5 hover:border-indigo-500/30 transition-all duration-300 shadow-2xl">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">Total Suppliers</p>
                        <h3 class="text-3xl font-bold text-white mt-2">{{ $adminStats['total_suppliers'] }}</h3>
                    </div>
                    <div class="p-3 bg-indigo-500/10 text-indigo-400 rounded-2xl group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center gap-1 text-[10px] font-bold text-emerald-500 bg-emerald-500/10 w-max px-2 py-1 rounded-lg">
                    ↑ Dynamic Node Network
                </div>
            </div>

            <div class="group p-6 rounded-3xl bg-[#1a1c26]/50 border border-white/5 hover:border-emerald-500/30 transition-all duration-300 shadow-2xl">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">Active Orders</p>
                        <h3 class="text-3xl font-bold text-white mt-2">{{ $adminStats['active_orders'] }}</h3>
                    </div>
                    <div class="p-3 bg-emerald-500/10 text-emerald-400 rounded-2xl group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-4 text-[10px] font-bold text-emerald-500 bg-emerald-500/10 w-max px-2 py-1 rounded-lg">
                    In Transit / Processing
                </div>
            </div>

            <div class="group p-6 rounded-3xl bg-[#1a1c26]/50 border border-white/5 hover:border-orange-500/30 transition-all duration-300 shadow-2xl">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">Total Revenue</p>
                        <h3 class="text-3xl font-bold text-white mt-2">₱{{ number_format($adminStats['total_revenue'] / 1000, 1) }}K</h3>
                    </div>
                    <div class="p-3 bg-orange-500/10 text-orange-400 rounded-2xl group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                        </svg>
                    </div>
                </div>
                <p class="mt-4 text-[10px] text-slate-500 font-bold uppercase tracking-widest italic">
                    Verified Deliveries
                </p>
            </div>

            <div class="group p-6 rounded-3xl bg-[#1a1c26]/50 border border-white/5 hover:border-purple-500/30 transition-all duration-300 shadow-2xl">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">Pending Approvals</p>
                        <h3 class="text-3xl font-bold text-white mt-2">{{ $adminStats['pending_approvals'] }}</h3>
                    </div>
                    <div class="p-3 bg-purple-500/10 text-purple-400 rounded-2xl group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-4 text-[10px] font-bold text-purple-400 bg-purple-500/10 w-max px-2 py-1 rounded-lg">
                    Action Required
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2 bg-[#1a1c26]/30 border border-white/5 rounded-3xl p-8 backdrop-blur-sm shadow-2xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-600/5 blur-[100px]"></div>

                <h3 class="text-white font-bold text-xl mb-6 flex justify-between items-center">
                    Recent Activity
                    <a href="{{ route('admin.orders.index') }}" class="text-xs text-indigo-400 hover:text-indigo-300 font-bold uppercase tracking-tighter">View All →</a>
                </h3>

                <div class="space-y-6">
                    @forelse($recentActivity as $order)
                    <div class="flex items-center gap-4 p-4 rounded-2xl hover:bg-white/5 transition border border-transparent hover:border-white/5">
                        <div class="w-12 h-12 bg-white/5 rounded-xl flex items-center justify-center text-xl text-indigo-400">
                            {{ $order->status === 'Delivered' ? '✅' : '📦' }}
                        </div>
                        <div class="flex-1">
                            <p class="text-white font-semibold text-sm">{{ $order->product_name }}</p>
                            <p class="text-slate-500 text-xs mt-1">{{ $order->order_number }} • {{ $order->user->name }}</p>
                        </div>
                        <div class="text-right">
                             <span class="text-[10px] font-bold uppercase px-2 py-1 rounded bg-white/5 text-slate-400">{{ $order->status }}</span>
                             <p class="text-slate-600 text-[10px] font-bold mt-1">{{ $order->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-slate-500 text-sm">No recent activity to show.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-gradient-to-b from-indigo-900/20 to-purple-900/20 border border-white/10 rounded-3xl p-8 shadow-2xl">
                <h3 class="text-white font-bold text-lg mb-4 text-center">System Status</h3>

                <div class="mb-8" style="height: 200px;">
                    <canvas id="statusChart"></canvas>
                </div>

                <div class="space-y-4 mt-6">
                    <div class="flex justify-between text-xs font-bold uppercase text-slate-400">
                        <span>Active Shipments</span>
                        <span class="text-indigo-400">{{ $adminStats['active_orders'] }} Units</span>
                    </div>
                    <div class="w-full bg-white/5 h-2 rounded-full">
                        <div class="bg-indigo-500 h-full rounded-full" style="width: 45%"></div>
                    </div>

                    <div class="flex justify-between text-xs font-bold uppercase text-slate-400 mt-6">
                        <span>Market Penetration</span>
                        <span class="text-emerald-400">Stable</span>
                    </div>
                    <div class="w-full bg-white/5 h-2 rounded-full">
                        <div class="bg-emerald-500 h-full w-[99%] rounded-full shadow-[0_0_8px_rgba(16,185,129,0.5)]"></div>
                    </div>
                </div>

                <div class="mt-10 p-4 bg-indigo-600 rounded-2xl text-center shadow-lg hover:bg-indigo-500 transition cursor-pointer">
                    <p class="text-white font-bold">Generate System Report</p>
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
                        backgroundColor: ['#F59E0B', '#3B82F6', '#8B5CF6', '#10B981', '#EF4444'],
                        hoverOffset: 15,
                        borderWidth: 0
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    cutout: '82%',
                    plugins: {
                        legend: { 
                            display: true, 
                            position: 'bottom',
                            labels: {
                                color: '#94a3b8',
                                usePointStyle: true,
                                font: { size: 10 }
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>