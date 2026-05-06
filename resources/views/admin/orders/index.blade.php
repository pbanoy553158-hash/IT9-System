<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <span class="text-[#5046e5] font-bold text-xs tracking-widest uppercase">Operations</span>
            <span class="h-4 w-[1px] bg-white/10"></span>
            <span class="text-white font-medium tracking-tight text-lg">Order Management</span>
        </div>
    </x-slot>

    <style>
        .ocean-dark-panel {
            background: linear-gradient(145deg, #171629 0%, #0d0b1a 100%);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .row-glow:hover {
            background: linear-gradient(90deg, rgba(80, 70, 229, 0.04) 0%, transparent 100%);
        }

        /* Status Colors */
        .status-pending { background: rgba(245, 158, 11, 0.1); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.2); }
        .status-processing { background: rgba(59, 130, 246, 0.1); color: #3b82f6; border: 1px solid rgba(59, 130, 246, 0.2); }
        .status-shipped { background: rgba(139, 92, 246, 0.1); color: #8b5cf6; border: 1px solid rgba(139, 92, 246, 0.2); }
        .status-delivered { background: rgba(16, 185, 129, 0.1); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2); }
        .status-canceled { background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); }

        /* Action Buttons */
        .btn-action {
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 9px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .btn-approve { background: #5046e5; color: white; }
        .btn-approve:hover { background: #6366f1; transform: translateY(-1px); }
        .btn-cancel { background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); }
        .btn-cancel:hover { background: #ef4444; color: white; }

        /* --- STYLED PAGINATION --- */
        .custom-pagination { display: flex; gap: 6px; align-items: center; }
        .pg-btn {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #94a3b8;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 600;
            transition: all 0.2s;
            text-decoration: none;
        }
        .pg-btn.active { background: #5046e5; border-color: #5046e5; color: white; }
        .pg-disabled { opacity: 0.3; cursor: not-allowed; }
    </style>

    <div class="py-8 space-y-6 max-w-[1400px] mx-auto px-8">
        
        <div class="flex flex-col md:flex-row justify-between items-end gap-6 px-4">
            <div>
                <h1 class="text-white font-semibold text-2xl tracking-tighter leading-none">Recent Orders</h1>
                <p class="text-slate-500 text-sm mt-2 italic font-medium">Monitoring real-time transaction stream</p>
            </div>
            
            <div class="pb-1">
                <span class="px-4 py-2 bg-[#5046e5]/10 text-[#5046e5] text-[11px] font-bold rounded-lg border border-[#5046e5]/20 flex items-center gap-2">
                    <div class="w-1.5 h-1.5 bg-[#5046e5] rounded-full animate-pulse shadow-[0_0_8px_rgba(80,70,229,0.8)]"></div>
                    System Online
                </span>
            </div>
        </div>

        <div class="ocean-dark-panel rounded-[1.8rem] shadow-2xl overflow-hidden mt-2 mx-2">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[12px] text-slate-500 border-b border-white/5 bg-white/[0.01] font-medium">
                            <th class="px-7 py-4">Ref Number</th>
                            <th class="px-7 py-4">Client Identity</th>
                            <th class="px-7 py-4 text-center">Status</th>
                            <th class="px-7 py-4 text-center">Amount</th>
                            <th class="px-7 py-4 text-center">Date Created</th>
                            <th class="px-7 py-4 text-right">Approval Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($orders as $order)
                            <tr class="row-glow transition-colors group">
                                <td class="px-7 py-5">
                                    <span class="text-sm font-mono font-bold text-[#5046e5] tracking-tighter">
                                        {{ $order->order_number }}
                                    </span>
                                </td>
                                <td class="px-7 py-5">
                                    <div class="text-sm font-normal text-white tracking-tight leading-tight">
                                        {{ $order->user->name ?? 'Guest Node' }}
                                    </div>
                                    <div class="text-[9px] font-medium text-slate-500 mt-0.5 tracking-tight italic uppercase">Identity Verified</div>
                                </td>
                                <td class="px-7 py-5 text-center">
                                    @php
                                        $statusClass = 'status-' . strtolower($order->status);
                                    @endphp
                                    <span class="px-3 py-1 {{ $statusClass }} rounded-md text-[10px] font-bold uppercase tracking-widest">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="px-7 py-5 text-center">
                                    <span class="text-xs font-semibold text-emerald-400 tracking-tight">
                                        ₱{{ number_format($order->total_amount, 2) }}
                                    </span>
                                </td>
                                <td class="px-7 py-5 text-center text-slate-500 text-xs font-medium">
                                    {{ $order->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-7 py-5 text-right">
                                    <div class="flex justify-end gap-2">
                                        @if($order->status == 'Pending')
                                            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="Processing">
                                                <button type="submit" class="btn-action btn-approve">Process</button>
                                            </form>
                                        @elseif($order->status == 'Processing')
                                            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="Shipped">
                                                <button type="submit" class="btn-action btn-approve">Ship Order</button>
                                            </form>
                                        @elseif($order->status == 'Shipped')
                                            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="Delivered">
                                                <button type="submit" class="btn-action btn-approve">Mark Delivered</button>
                                            </form>
                                        @endif

                                        {{-- Global Cancel Button (Only if not delivered or already canceled) --}}
                                        @if(!in_array($order->status, ['Delivered', 'Canceled']))
                                            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" onsubmit="return confirm('Cancel this transaction?')">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="Canceled">
                                                <button type="submit" class="btn-action btn-cancel">Cancel</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-20 text-center text-slate-600 text-[11px] italic uppercase tracking-widest">
                                    No records detected in network stream
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-7 py-5 border-t border-white/5 bg-white/[0.01] flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-[9px] text-slate-500 font-bold uppercase tracking-widest">
                    Network Capacity: <span class="text-white">{{ $orders->total() }}</span> Units
                </div>
                
                <div class="custom-pagination">
                    @if ($orders->onFirstPage())
                        <span class="pg-btn pg-disabled"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></span>
                    @else
                        <a href="{{ $orders->previousPageUrl() }}" class="pg-btn"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></a>
                    @endif

                    @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                        @if ($page == $orders->currentPage())
                            <span class="pg-btn active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="pg-btn">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($orders->hasMorePages())
                        <a href="{{ $orders->nextPageUrl() }}" class="pg-btn"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a>
                    @else
                        <span class="pg-btn pg-disabled"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>