<x-app-layout>
    <div class="w-full max-w-2xl mx-auto py-6 md:py-10 px-4 antialiased font-['Inter']">
        
        <div class="mb-4 md:mb-6">
            <a href="{{ route('supplier.invoices.index') }}" 
               class="inline-flex items-center gap-2 text-[11px] font-semibold text-slate-500 hover:text-white transition-colors duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to invoices
            </a>
        </div>
        
        <div class="bg-white rounded-xl md:rounded-2xl shadow-xl overflow-hidden border border-slate-100 print:shadow-none print:border-0" id="invoice">
            
            <div class="bg-[#1c1c2d] text-white p-6 md:p-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 md:gap-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-indigo-500/10 border border-indigo-500/30 rounded-lg flex items-center justify-center text-xl">
                        📦
                    </div>
                    <div>
                        <h1 class="text-lg md:text-xl font-bold tracking-tight text-white">SupplyManager</h1>
                        <p class="text-indigo-400 text-[10px] font-medium tracking-wide">Official Invoice</p>
                    </div>
                </div>
                <div class="text-left md:text-right">
                    <p class="text-xl md:text-2xl font-mono font-bold text-indigo-400 leading-none tracking-tighter uppercase">
                        {{ $order->order_number }}
                    </p>
                    <p class="text-[10px] text-slate-400 mt-1 uppercase">{{ $order->created_at->format('M d, Y') }}</p>
                </div>
            </div>

            <div class="p-6 md:p-8">
                <div class="grid grid-cols-2 gap-4 md:gap-8 mb-8 md:mb-10">
                    <div>
                        <p class="text-[10px] md:text-[11px] font-bold text-slate-400 mb-1 md:mb-2 uppercase">Billed to</p>
                        <p class="font-bold text-slate-800 text-sm">{{ $order->user->name }}</p>
                        <p class="text-slate-500 text-xs truncate max-w-[140px] md:max-w-full">{{ $order->user->email }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] md:text-[11px] font-bold text-slate-400 mb-1 md:mb-2 uppercase">Order status</p>
                        <span class="inline-flex px-3 md:px-4 py-1 rounded-full text-[9px] md:text-[10px] font-bold tracking-wide
                            @if($order->status === 'Delivered') bg-emerald-50 text-emerald-600
                            @elseif($order->status === 'Shipped') bg-blue-50 text-blue-600
                            @else bg-amber-50 text-amber-700 @endif">
                            {{ $order->status }}
                        </span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[400px] md:min-w-full">
                        <thead>
                            <tr class="border-b border-slate-100">
                                <th class="text-left pb-3 text-[10px] md:text-[11px] font-bold text-slate-400 uppercase">Item</th>
                                <th class="text-center pb-3 text-[10px] md:text-[11px] font-bold text-slate-400 uppercase">Qty</th>
                                <th class="text-right pb-3 text-[10px] md:text-[11px] font-bold text-slate-400 uppercase">Price</th>
                                <th class="text-right pb-3 text-[10px] md:text-[11px] font-bold text-slate-400 uppercase">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <tr>
                                <td class="py-4 md:py-6 text-xs font-semibold text-slate-700">{{ $order->product_name }}</td>
                                <td class="py-4 md:py-6 text-center text-xs text-slate-600">{{ $order->quantity }}</td>
                                <td class="py-4 md:py-6 text-right text-xs text-slate-600">₱{{ number_format($order->total_amount / max($order->quantity, 1), 2) }}</td>
                                <td class="py-4 md:py-6 text-right font-bold text-base md:text-lg text-slate-900">₱{{ number_format($order->total_amount, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-end border-t border-slate-100 pt-6">
                    <div class="text-right">
                        <p class="text-[9px] md:text-[10px] font-bold text-slate-400 mb-1 uppercase">Total amount due</p>
                        <p class="text-2xl md:text-3xl font-black text-slate-900 tracking-tighter">
                            ₱{{ number_format($order->total_amount, 2) }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-slate-50/50 px-6 md:px-8 py-4 text-center text-[9px] font-medium text-slate-400 border-t border-slate-100 italic">
                Thank you for your business • Computer-generated document
            </div>
        </div>

        <div class="flex justify-end mt-6 md:mt-8 print:hidden">
            <button onclick="window.print()" 
                    class="w-full md:w-auto flex justify-center items-center gap-2 px-8 py-3 bg-[#5a5af3] hover:bg-[#4f46e5] text-white font-bold text-[12px] rounded-full transition-all shadow-[0_0_20px_rgba(90,90,243,0.35)] active:scale-95">
                <span class="text-lg leading-none">+</span>
                Download or Print
            </button>
        </div>
    </div>
</x-app-layout>