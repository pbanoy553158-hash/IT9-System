<x-app-layout>
    <div class="min-h-screen bg-[#0d0b1a] py-8 px-6 font-['Inter'] antialiased">
        <div class="max-w-4xl mx-auto space-y-6">
            <a href="{{ route('supplier.orders.index') }}" class="text-[10px] font-bold text-slate-500 hover:text-[#5851f2] uppercase tracking-[0.2em]">← Return to Archive</a>

            <div class="bg-[#1b1931] border border-white/5 rounded-[2.5rem] p-10 shadow-2xl">
                <div class="grid md:grid-cols-2 gap-12">
                    <div>
                        <p class="text-[10px] font-bold text-[#5851f2] uppercase tracking-widest mb-2">Item Identification</p>
                        <h1 class="text-4xl font-bold text-white tracking-tight leading-none mb-6">{{ $order->product_name }}</h1>
                        
                        <div class="flex items-center gap-4 mb-8">
                             <span class="px-3 py-1 bg-[#121124] border border-white/5 rounded-full text-[10px] font-bold text-slate-400 tracking-widest">ID #{{ $order->id }}</span>
                             <span class="px-3 py-1 bg-[#5851f2]/10 border border-[#5851f2]/20 rounded-full text-[10px] font-bold text-[#5851f2] uppercase tracking-widest">{{ $order->status }}</span>
                        </div>
                    </div>

                    <div class="bg-[#121124] rounded-[2rem] p-8 border border-white/5 flex flex-col justify-center">
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Current Valuation</p>
                        <h2 class="text-5xl font-bold text-white tabular-nums tracking-tighter">₱{{ number_format($order->unit_price * $order->quantity, 2) }}</h2>
                        <p class="text-[10px] text-slate-600 font-bold uppercase mt-4 tracking-widest">{{ $order->quantity }} Units Total</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>