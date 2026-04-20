<x-app-layout>
    <x-slot name="header">Product Details</x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto space-y-6">

            {{-- Back --}}
            <a href="{{ route('supplier.products.index') }}"
               class="text-xs text-indigo-400 hover:text-white">
                ← Back to Inventory
            </a>

            {{-- Main Card --}}
            <div class="bg-white/[0.02] border border-white/5 rounded-2xl p-6 flex gap-6">

                {{-- Image --}}
                <div class="h-40 w-40 rounded-xl overflow-hidden bg-white/5 border border-white/10">
                    @if($product->image_path)
                        <img src="{{ asset('storage/' . $product->image_path) }}"
                             class="h-full w-full object-cover">
                    @else
                        <div class="h-full w-full flex items-center justify-center text-slate-600">
                            No Image
                        </div>
                    @endif
                </div>

                {{-- Info --}}
                <div class="flex-1 space-y-2">

                    <h1 class="text-xl font-bold text-white">
                        {{ $product->name }}
                    </h1>

                    <p class="text-xs text-indigo-400 font-mono">
                        SKU: {{ $product->sku }}
                    </p>

                    <div class="text-sm text-slate-400">
                        Category:
                        <span class="text-white">
                            {{ $product->category->name ?? 'Uncategorized' }}
                        </span>
                    </div>

                    <div class="text-sm text-slate-400">
                        Price:
                        <span class="text-white font-bold">
                            ₱{{ number_format($product->price, 2) }}
                        </span>
                    </div>

                    <div class="text-sm text-slate-400">
                        Stock:
                        <span class="text-white font-bold">
                            {{ $product->stock }} {{ $product->unit }}
                        </span>
                    </div>

                    <div class="text-sm text-slate-400">
                        Status:
                        <span class="text-white">
                            {{ $product->status }}
                        </span>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>