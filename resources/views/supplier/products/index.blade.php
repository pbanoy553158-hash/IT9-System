<x-app-layout>
    <x-slot name="header">Inventory</x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8 antialiased">
        <div class="max-w-7xl mx-auto space-y-6">

            {{-- Compact Header --}}
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-xl font-extrabold text-white tracking-tight">Supply Catalog</h1>
                    <p class="text-[11px] text-slate-500 font-medium tracking-wide">
                        Manage and monitor asset availability.
                    </p>
                </div>

                {{-- ✅ RESTORED EXACT BUTTON --}}
                <a href="{{ route('supplier.products.create') }}"
                   class="bg-indigo-600 hover:bg-indigo-500 text-white text-xs px-4 py-2 rounded-lg font-bold">
                    Register Product
                </a>
            </div>

            {{-- FILTER --}}
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between bg-white/[0.02] border border-white/5 p-4 rounded-2xl backdrop-blur-sm">

                <form action="{{ route('supplier.products.index') }}" method="GET"
                      class="flex flex-1 flex-col md:flex-row gap-3 w-full">

                    {{-- Search --}}
                    <div class="relative flex-1">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-3.5 w-3.5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>

                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search SKU or name..."
                               class="w-full bg-white/[0.03] border border-white/10 rounded-xl pl-9 pr-4 py-2 text-[11px] text-white outline-none focus:border-indigo-500/50 transition-all">
                    </div>

                    {{-- Category --}}
                    <select name="category" onchange="this.form.submit()"
                            class="bg-[#0d0d12] border border-white/10 rounded-xl px-4 py-2 text-[11px] text-slate-400">

                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>

                    <div class="flex gap-2">
                        <button type="submit"
                                class="px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl text-[10px] font-bold text-white uppercase">
                            Filter
                        </button>

                        @if(request()->has('search') || request()->has('category'))
                            <a href="{{ route('supplier.products.index') }}"
                               class="px-4 py-2 bg-red-500/10 hover:bg-red-500/20 border border-red-500/20 rounded-xl text-[10px] font-bold text-red-400 uppercase">
                                Clear
                            </a>
                        @endif
                    </div>

                </form>
            </div>

            {{-- TABLE --}}
            <div class="bg-white/[0.02] border border-white/5 rounded-[1.5rem] shadow-2xl backdrop-blur-md overflow-hidden">

                <div class="px-6 py-4 border-b border-white/5 flex justify-between items-center bg-white/[0.01]">
                    <h3 class="text-sm font-bold text-white">Active Inventory</h3>
                    <span class="text-[10px] text-slate-500">
                        Total Nodes: {{ $products->count() }}
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">

                        <thead>
                        <tr class="bg-white/[0.01]">
                            <th class="px-6 py-4 text-left text-[9px] text-slate-500 uppercase">Asset Info</th>
                            <th class="px-6 py-4 text-center text-[9px] text-slate-500 uppercase">Category</th>
                            <th class="px-6 py-4 text-center text-[9px] text-slate-500 uppercase">Status</th>
                            <th class="px-6 py-4 text-center text-[9px] text-slate-500 uppercase">Stock</th>
                            <th class="px-6 py-4 text-right text-[9px] text-slate-500 uppercase">Price</th>
                            <th class="px-6 py-4 text-right text-[9px] text-slate-500 uppercase">Action</th>
                        </tr>
                        </thead>

                        <tbody class="divide-y divide-white/5">

                        @forelse($products as $product)

                            @php
                                $status = strtolower($product->status);

                                $statusClass = match($status) {
                                    'active', 'available' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                    'pending' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                    default => 'bg-red-500/10 text-red-400 border-red-500/20',
                                };
                            @endphp

                            <tr class="hover:bg-white/[0.03] transition-all">

                                {{-- PRODUCT INFO --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">

                                        <div class="h-10 w-10 rounded-xl bg-white/5 border border-white/10 overflow-hidden">
                                            @if($product->image_path)
                                                <img src="{{ asset('storage/' . $product->image_path) }}"
                                                     class="h-full w-full object-cover">
                                            @endif
                                        </div>

                                        <div>
                                            <div class="text-white font-bold text-[13px]">
                                                {{ $product->name }}
                                            </div>
                                            <div class="text-[9px] text-indigo-400 font-mono">
                                                {{ $product->sku }}
                                            </div>
                                        </div>

                                    </div>
                                </td>

                                <td class="px-6 py-4 text-center text-[10px] text-slate-400">
                                    {{ $product->category->name ?? 'Uncategorized' }}
                                </td>

                                {{-- STATUS (GREEN ACTIVE FIX) --}}
                                <td class="px-6 py-4 text-center">
                                    <span class="px-3 py-1 text-[9px] font-black uppercase border rounded-full {{ $statusClass }}">
                                        {{ $product->status }}
                                    </span>
                                </td>

                                {{-- STOCK (BOLD) --}}
                                <td class="px-6 py-4 text-center">
                                    <span class="font-black text-white text-sm">
                                        {{ $product->stock }}
                                    </span>
                                </td>

                                {{-- PRICE (BOLD LIKE ORDERS) --}}
                                <td class="px-6 py-4 text-right">
                                    <span class="font-black text-white text-sm">
                                        ₱{{ number_format($product->price, 2) }}
                                    </span>
                                </td>

                                {{-- ACTION --}}
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">

                                        {{-- VIEW (FIXED SAFE) --}}
                                        <button type="button"
                                            onclick='openViewModal(
                                                @json($product->name),
                                                @json($product->sku),
                                                @json($product->category->name ?? "Uncategorized"),
                                                @json($product->status),
                                                @json($product->stock),
                                                @json($product->unit),
                                                @json(number_format($product->price, 2)),
                                                @json($product->image_path ? asset("storage/".$product->image_path) : "")
                                            )'
                                            class="p-2 bg-white/5 hover:bg-blue-500/20 border border-white/5 rounded-lg text-slate-400 hover:text-blue-400">
                                            👁
                                        </button>

                                        {{-- EDIT --}}
                                        <a href="{{ route('supplier.products.edit', $product) }}"
                                           class="p-2 bg-white/5 hover:bg-indigo-500/20 border border-white/5 rounded-lg text-slate-400 hover:text-indigo-400">
                                            ✎
                                        </a>

                                        {{-- DELETE --}}
                                        <form action="{{ route('supplier.products.destroy', $product) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="p-2 bg-white/5 hover:bg-red-500/20 border border-white/5 rounded-lg text-slate-400 hover:text-red-400">
                                                🗑
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-10 text-slate-600">
                                    No products found
                                </td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- MODAL --}}
    <div id="viewModal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50">
        <div class="bg-[#0d0d12] border border-white/10 rounded-xl p-5 w-[420px]">

            <div class="flex justify-between mb-4">
                <h2 class="text-white font-bold">Product Details</h2>
                <button onclick="closeViewModal()" class="text-white">✕</button>
            </div>

            <div class="w-full flex justify-center mb-4">
                <img id="modalImage"
                     class="hidden max-h-[300px] w-auto object-contain rounded-xl border border-white/10 shadow-lg">
            </div>

            <div class="text-xs text-slate-300 space-y-2">
                <div>Name: <span id="modalName" class="text-white"></span></div>
                <div>SKU: <span id="modalSku" class="text-indigo-400"></span></div>
                <div>Category: <span id="modalCategory"></span></div>
                <div>Status: <span id="modalStatus"></span></div>
                <div>Stock: <span id="modalStock"></span></div>
                <div>Unit: <span id="modalUnit"></span></div>
                <div>Price: ₱<span id="modalPrice"></span></div>
            </div>

        </div>
    </div>

    {{-- SCRIPT --}}
    <script>
        function openViewModal(name, sku, category, status, stock, unit, price, image) {
            document.getElementById('viewModal').classList.remove('hidden');

            document.getElementById('modalName').innerText = name;
            document.getElementById('modalSku').innerText = sku;
            document.getElementById('modalCategory').innerText = category;
            document.getElementById('modalStatus').innerText = status;
            document.getElementById('modalStock').innerText = stock;
            document.getElementById('modalUnit').innerText = unit;
            document.getElementById('modalPrice').innerText = price;

            const img = document.getElementById('modalImage');

            if (image) {
                img.src = image;
                img.classList.remove('hidden');
            } else {
                img.classList.add('hidden');
            }
        }

        function closeViewModal() {
            document.getElementById('viewModal').classList.add('hidden');
        }
    </script>

</x-app-layout>