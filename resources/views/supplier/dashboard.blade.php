<x-app-layout>
<div class="py-6 space-y-5 font-['Inter'] antialiased max-w-7xl mx-auto px-4">

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">

        {{-- MAIN STATS --}}
        <div class="lg:col-span-8 bg-[#1e1b2e] border border-white/10 rounded-[2rem] p-6">

            <h2 class="text-xl font-bold text-white">Supplier Orders</h2>
            <p class="text-slate-500 text-xs">Track system activities in real time</p>

            <div class="mt-4">
                <h1 class="text-4xl font-extrabold text-white">
                    {{ $stats['total'] }}
                </h1>
            </div>

        </div>

        {{-- ACTION --}}
        <div class="lg:col-span-4 bg-indigo-600 rounded-[2rem] p-6 flex flex-col justify-between">

            <div>
                <h3 class="text-white font-bold text-xl">New Order</h3>
                <p class="text-indigo-100 text-xs mt-2">Create supply request</p>
            </div>

            <a href="{{ route('supplier.orders.create') }}"
               class="mt-6 bg-white text-indigo-900 text-[10px] font-bold py-3 rounded-xl text-center uppercase">
                Create Entry
            </a>

        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">

        {{-- SMALLER ACTIVITY TABLE --}}
        <div class="lg:col-span-8 bg-[#1e1b2e] border border-white/10 rounded-[1.2rem] overflow-hidden">

            <div class="px-4 py-3 border-b border-white/5">
                <h3 class="text-white text-sm font-bold">Recent Activity</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-xs">

                    <thead>
                        <tr class="text-slate-500 uppercase text-[9px] border-b border-white/5">
                            <th class="px-4 py-2 text-left">Activity</th>
                            <th class="px-4 py-2 text-center">Status</th>
                            <th class="px-4 py-2 text-right">Amount</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-white/5">

                        @forelse($activities as $activity)

                        <tr class="hover:bg-white/5">

                            {{-- ACTIVITY --}}
                            <td class="px-4 py-2">
                                <div class="flex items-center gap-3">

                                    {{-- IMAGE --}}
                                    <div class="w-9 h-9 rounded-lg overflow-hidden bg-black flex-shrink-0">
                                        @if($activity->image)
                                            <img src="{{ asset('storage/'.$activity->image) }}"
                                                 class="w-full h-full object-cover">
                                        @endif
                                    </div>

                                    <div>
                                        <p class="text-white text-xs font-semibold">
                                            {{ $activity->title }}
                                        </p>
                                        <p class="text-slate-500 text-[9px]">
                                            {{ $activity->description }}
                                        </p>
                                    </div>

                                </div>
                            </td>

                            {{-- STATUS --}}
                            <td class="text-center px-4 py-2">
                                <span class="text-[9px] px-2 py-1 rounded bg-white/10 text-white">
                                    {{ $activity->status ?? '-' }}
                                </span>
                            </td>

                            {{-- AMOUNT --}}
                            <td class="text-right px-4 py-2 text-white font-bold text-xs">
                                ₱{{ number_format($activity->amount ?? 0, 2) }}
                            </td>

                        </tr>

                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-6 text-slate-500 text-xs">
                                No activity yet
                            </td>
                        </tr>
                        @endforelse

                    </tbody>

                </table>
            </div>

        </div>

        {{-- SIDEBAR --}}
        <div class="lg:col-span-4 space-y-3">

            <div class="bg-[#1e1b2e] border border-white/10 rounded-2xl p-4 flex gap-3 items-center">
                <div class="w-10 h-10 bg-indigo-500/10 rounded-xl flex items-center justify-center">📄</div>
                <div>
                    <p class="text-white text-xs font-bold">Manifest Archives</p>
                    <p class="text-slate-500 text-[10px]">Invoice exports</p>
                </div>
            </div>

            <div class="bg-[#1e1b2e] border border-white/10 rounded-2xl p-4 flex gap-3 items-center">
                <div class="w-10 h-10 bg-indigo-500/10 rounded-xl flex items-center justify-center">🎧</div>
                <div>
                    <p class="text-white text-xs font-bold">Admin Support</p>
                    <p class="text-slate-500 text-[10px]">Direct helpdesk</p>
                </div>
            </div>

        </div>

    </div>

</div>
</x-app-layout>