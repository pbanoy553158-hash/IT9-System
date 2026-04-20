<x-app-layout>
    <x-slot name="header">Inventory</x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8 antialiased">
        <div class="max-w-7xl mx-auto space-y-6">

            {{-- HEADER --}}
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-xl font-extrabold text-white tracking-tight">Supply Catalog</h1>
                    <p class="text-[11px] text-slate-500 font-medium">
                        Manage and monitor asset availability.
                    </p>
                </div>

                <a href="{{ route('supplier.products.create') }}"
                   class="bg-indigo-600 hover:bg-indigo-500 text-white text-xs px-4 py-2 rounded-lg font-bold">
                    Register Product
                </a>
            </div>

            <div class="flex flex-col md:flex-row gap-4 items-center justify-between bg-white/[0.02] border border-white/5 p-4 rounded-2xl">
                <form action="{{ route('supplier.products.index') }}" method="GET"
                      class="flex flex-1 flex-col md:flex-row gap-3 w-full">

                    <div class="relative flex-1">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search SKU or name..."
                               class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-4 py-2 text-xs text-white">
                    </div>

                    <select name="category" onchange="this.form.submit()"
                            class="bg-[#0d0d12] border border-white/10 rounded-xl px-4 py-2 text-xs text-slate-300">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>

                </form>
            </div>

            {{-- TABLE --}}
            <div class="bg-white/[0.02] border border-white/5 rounded-2xl overflow-hidden">

                <div class="p-4 border-b border-white/5 flex justify-between items-center">
                    <div class="text-white font-bold text-sm">Active Inventory</div>
                    <div class="text-slate-500 text-xs">Total Items: {{ $products->count() }}</div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="text-[10px] text-slate-500 bg-white/5">
                            <tr>
                                <th class="text-left px-6 py-3">Asset Info</th>
                                <th class="text-center px-6 py-3">Category</th>
                                <th class="text-center px-6 py-3">Status</th>
                                <th class="text-center px-6 py-3">Stock</th>
                                <th class="text-right px-6 py-3">Price</th>
                                <th class="text-right px-6 py-3">Action</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-white/5">
                            @forelse($products as $product)
                            <tr class="hover:bg-white/5 transition">
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-3">

                                        <div class="h-14 w-14 rounded-xl overflow-hidden bg-black border border-white/10 flex-shrink-0">
                                            @if($product->image_path)
                                                <img src="{{ asset('storage/' . $product->image_path) }}"
                                                     class="w-full h-full object-contain">
                                            @else
                                                <div class="flex items-center justify-center h-full text-[9px] text-slate-600">
                                                    No Image
                                                </div>
                                            @endif
                                        </div>

                                        <div class="min-w-0">
                                            <div class="text-white font-semibold text-xs truncate">
                                                {{ $product->name }}
                                            </div>
                                            <div class="text-[10px] text-slate-400 font-mono">
                                                {{ $product->sku }}
                                            </div>
                                        </div>

                                    </div>
                                </td>

                                <td class="px-6 py-3 text-center text-slate-400 text-xs">
                                    {{ $product->category->name ?? 'Uncategorized' }}
                                </td>

                                <td class="px-6 py-3 text-center text-xs text-slate-300">
                                    {{ $product->status }}
                                </td>

                                <td class="px-6 py-3 text-center text-white font-bold text-xs">
                                    {{ $product->stock }}
                                </td>

                                <td class="px-6 py-3 text-right text-white font-bold text-xs">
                                    ₱{{ number_format($product->price, 2) }}
                                </td>

                                <td class="px-6 py-3 text-right">
                                    <button
                                        onclick="openViewModal(
                                            '{{ $product->name }}',
                                            '{{ $product->sku }}',
                                            '{{ $product->category->name ?? 'Uncategorized' }}',
                                            '{{ $product->status }}',
                                            '{{ $product->stock }}',
                                            '{{ $product->unit }}',
                                            '{{ number_format($product->price, 2) }}',
                                            '{{ $product->image_path ? asset('storage/'.$product->image_path) : '' }}'
                                        )"
                                        class="bg-white/5 hover:bg-white/10 p-2 rounded-lg text-slate-300">
                                        👁
                                    </button>
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-16 text-slate-500 text-xs">
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
    <div id="viewModal" class="hidden fixed inset-0 bg-black/70 flex items-center justify-center z-50">

        <div class="bg-[#0d0d12] border border-white/10 rounded-2xl p-6 w-[420px]">

            <div class="flex justify-between mb-4">
                <h2 class="text-white font-bold">Product Details</h2>
                <button onclick="closeViewModal()" class="text-white">✕</button>
            </div>

            <div class="flex justify-center mb-4">
                <img id="modalImage"
                     class="hidden max-h-[280px] object-contain rounded-xl border border-white/10">
            </div>

            <div class="text-xs text-slate-300 space-y-2">
                <div>Name: <span id="modalName" class="text-white"></span></div>
                <div>SKU: <span id="modalSku" class="text-white"></span></div>
                <div>Category: <span id="modalCategory" class="text-white"></span></div>
                <div>Status: <span id="modalStatus" class="text-white"></span></div>
                <div>Stock: <span id="modalStock" class="text-white"></span></div>
                <div>Unit: <span id="modalUnit" class="text-white"></span></div>
                <div>Price: ₱<span id="modalPrice" class="text-white"></span></div>
            </div>

        </div>
    </div>

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