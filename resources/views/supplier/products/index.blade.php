<x-app-layout>
    <x-slot name="header">Inventory</x-slot>

    {{-- SUCCESS CONFIRMATION TOAST --}}
    @if(session('success'))
        <div id="success-toast" class="fixed top-6 right-6 z-[100] animate-bounce">
            <div class="bg-emerald-500 text-white px-6 py-3 rounded-2xl shadow-[0_0_40px_-10px_rgba(16,185,129,0.5)] flex items-center gap-3">
                <div class="bg-white/20 rounded-full p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-[10px] uppercase font-black tracking-widest leading-none">Success</span>
                    <span class="text-xs font-bold leading-tight">{{ session('success') }}</span>
                </div>
            </div>
        </div>
        <script>
            setTimeout(() => {
                const toast = document.getElementById('success-toast');
                toast.style.transition = 'all 0.5s ease';
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(-20px)';
                setTimeout(() => toast.remove(), 500);
            }, 4000);
        </script>
    @endif

    <div class="py-6 px-4 sm:px-6 lg:px-8 antialiased font-['Inter']">
        <div class="max-w-7xl mx-auto space-y-6">

            {{-- HEADER --}}
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-xl font-extrabold text-white tracking-tight">Supply Catalog</h1>
                    <p class="text-[11px] text-slate-500 font-medium">Manage and monitor asset availability.</p>
                </div>

                <a href="{{ route('supplier.products.create') }}"
                   class="bg-indigo-600 hover:bg-indigo-500 text-white text-xs px-4 py-2 rounded-lg font-bold transition-all active:scale-95">
                    Register Product
                </a>
            </div>

            {{-- SEARCH & FILTER --}}
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between bg-white/[0.02] border border-white/5 p-4 rounded-2xl">
                <form action="{{ route('supplier.products.index') }}" method="GET" class="flex flex-1 flex-col md:flex-row gap-3 w-full">
                    <div class="relative flex-1">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search SKU or name..."
                               class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-4 py-2 text-xs text-white focus:border-indigo-500/50 outline-none transition-all">
                    </div>

                    <select name="category" onchange="this.form.submit()"
                            class="bg-[#0d0d12] border border-white/10 rounded-xl px-4 py-2 text-xs text-slate-300 outline-none focus:border-indigo-500/50">
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
                <div class="p-4 border-b border-white/5 flex justify-between items-center bg-white/[0.01]">
                    <div class="text-white font-bold text-sm tracking-tight">Active Inventory</div>
                    <div class="text-slate-500 text-[10px] uppercase font-bold tracking-widest">Total Items: {{ $products->count() }}</div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="text-[10px] text-slate-500 bg-white/5 uppercase tracking-widest">
                            <tr>
                                <th class="text-left px-6 py-4">Asset Info</th>
                                <th class="text-center px-6 py-4">Category</th>
                                <th class="text-center px-6 py-4">Status</th>
                                <th class="text-center px-6 py-4">Stock</th>
                                <th class="text-right px-6 py-4">Price</th>
                                <th class="text-right px-6 py-4">Action</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-white/5">
                            @forelse($products as $product)
                            <tr class="hover:bg-white/[0.03] transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-lg overflow-hidden bg-black border border-white/10 flex-shrink-0 shadow-2xl">
                                            @if($product->image_path)
                                                <img src="{{ asset('storage/' . $product->image_path) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="flex items-center justify-center h-full text-[8px] text-slate-600 font-bold uppercase">N/A</div>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <div class="text-white font-bold text-xs truncate group-hover:text-indigo-400 transition-colors">{{ $product->name }}</div>
                                            <div class="text-[10px] text-slate-500 font-mono tracking-tighter">{{ $product->sku }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <span class="text-slate-400 text-xs">{{ $product->category->name ?? 'Uncategorized' }}</span>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <span class="px-2 py-0.5 rounded text-[9px] font-bold uppercase tracking-tighter {{ $product->status == 'Active' ? 'bg-emerald-500/10 text-emerald-500 border border-emerald-500/20' : 'bg-slate-500/10 text-slate-500 border border-slate-500/20' }}">
                                        {{ $product->status }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <span class="text-white font-bold text-xs">{{ $product->stock }}</span>
                                    <span class="text-[10px] font-medium text-slate-500 uppercase tracking-tighter">{{ $product->unit }}</span>
                                </td>

                                <td class="px-6 py-4 text-right">
                                    <span class="text-white font-bold text-xs">₱{{ number_format($product->price, 2) }}</span>
                                </td>

                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <button onclick="openViewModal('{{ addslashes($product->name) }}', '{{ $product->sku }}', '{{ $product->category->name ?? 'Uncategorized' }}', '{{ $product->status }}', '{{ $product->stock }}', '{{ $product->unit }}', '{{ number_format($product->price, 2) }}', '{{ $product->image_path ? asset('storage/'.$product->image_path) : '' }}')"
                                                class="p-2 bg-white/5 rounded-lg text-slate-400 hover:text-white hover:bg-white/10 transition-all shadow-sm" title="View Details">
                                            👁
                                        </button>

                                        <a href="{{ route('supplier.products.edit', $product->id) }}" 
                                           class="p-2 bg-white/5 rounded-lg text-slate-400 hover:text-indigo-400 hover:bg-indigo-400/10 transition-all shadow-sm" title="Edit Product">
                                            ✏️
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-20">
                                    <div class="text-slate-600 text-xs uppercase font-bold tracking-widest">Empty Inventory</div>
                                    <p class="text-slate-500 text-[10px] mt-1">No products found matching your criteria.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="viewModal" class="hidden fixed inset-0 bg-black/90 backdrop-blur-sm flex items-center justify-center z-50 p-6">
        <div class="bg-[#0d0d12] border border-white/10 rounded-[2rem] p-8 w-full max-w-md shadow-2xl transition-all">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-white font-black uppercase tracking-widest text-xs">Asset Preview</h2>
                <button onclick="closeViewModal()" class="text-slate-500 hover:text-white transition p-2">✕</button>
            </div>

            <div class="aspect-square bg-black rounded-2xl border border-white/5 overflow-hidden mb-6 shadow-inner flex items-center justify-center">
                <img id="modalImage" class="w-full h-full object-contain hidden">
                <div id="modalNoImage" class="text-slate-700 text-[10px] uppercase font-black tracking-widest">No Image Attached</div>
            </div>

            <div class="space-y-4 text-xs">
                <div class="border-b border-white/5 pb-2">
                    <label class="text-slate-500 uppercase font-bold tracking-widest text-[9px] block mb-1">Product Identity</label>
                    <div id="modalName" class="text-white font-bold text-sm"></div>
                    <div id="modalSku" class="text-indigo-400 font-mono text-[10px]"></div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-slate-500 uppercase font-bold tracking-widest text-[9px] block mb-1">Stock Level</label>
                        <div class="text-white font-bold"><span id="modalStock"></span> <span id="modalUnit" class="text-slate-500 font-normal"></span></div>
                    </div>
                    <div>
                        <label class="text-slate-500 uppercase font-bold tracking-widest text-[9px] block mb-1">Category</label>
                        <div id="modalCategory" class="text-white font-bold"></div>
                    </div>
                </div>

                <div class="pt-4 border-t border-white/5 flex justify-between items-center">
                    <div>
                        <label class="text-slate-500 uppercase font-bold tracking-widest text-[9px] block mb-1">Valuation</label>
                        <div class="text-indigo-400 text-xl font-black tracking-tight">₱<span id="modalPrice"></span></div>
                    </div>
                    <div id="modalStatus" class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openViewModal(name, sku, category, status, stock, unit, price, image) {
            const modal = document.getElementById('viewModal');
            modal.classList.remove('hidden');

            document.getElementById('modalName').innerText = name;
            document.getElementById('modalSku').innerText = sku;
            document.getElementById('modalCategory').innerText = category;
            document.getElementById('modalStock').innerText = stock;
            document.getElementById('modalUnit').innerText = unit;
            document.getElementById('modalPrice').innerText = price;
            
            const statusBadge = document.getElementById('modalStatus');
            statusBadge.innerText = status;
            statusBadge.className = status === 'Active' 
                ? 'px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest bg-emerald-500/10 text-emerald-500 border border-emerald-500/20'
                : 'px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest bg-slate-500/10 text-slate-500 border border-slate-500/20';

            const img = document.getElementById('modalImage');
            const noImg = document.getElementById('modalNoImage');
            if (image) {
                img.src = image;
                img.classList.remove('hidden');
                noImg.classList.add('hidden');
            } else {
                img.classList.add('hidden');
                noImg.classList.remove('hidden');
            }
        }

        function closeViewModal() {
            document.getElementById('viewModal').classList.add('hidden');
        }

        // Close on Escape
        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeViewModal();
        });
    </script>
</x-app-layout>