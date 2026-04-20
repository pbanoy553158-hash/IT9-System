@extends('layouts.app')

@section('content')
<div class="max-w-xs mx-auto py-10">

    <div class="flex items-end justify-between mb-5 px-1">
        <div>
            <p class="text-[#5046e5] text-[10px] font-black uppercase tracking-[0.2em] leading-none mb-1">Product Editor</p>
            <h1 class="text-xl font-extrabold text-white tracking-tight">{{ $product->name }}</h1>
        </div>
        <a href="{{ route('supplier.products.index') }}" 
           class="text-[10px] font-bold uppercase tracking-widest text-slate-500 hover:text-white transition-colors pb-1">
            Cancel
        </a>
    </div>

    <form action="{{ route('supplier.products.update', $product) }}" 
          method="POST" 
          enctype="multipart/form-data" 
          class="bg-[#0d0b1a] border border-white/[0.05] rounded-[28px] p-5 shadow-2xl relative overflow-hidden">
        
        <div class="absolute -top-24 -right-24 w-48 h-48 bg-[#5046e5]/10 blur-[80px] rounded-full pointer-events-none"></div>
        
        @csrf
        @method('PATCH')

        <div class="relative z-10 space-y-4">
            
            {{-- Image Management Slot --}}
            <div class="flex items-center gap-4 p-3 rounded-2xl bg-white/[0.02] border border-white/[0.03]">
                <div class="shrink-0 relative">
                    @if($product->image_path)
                        <img src="{{ asset('storage/' . $product->image_path) }}" 
                             class="w-14 h-14 object-cover rounded-xl border border-white/10 shadow-lg">
                    @else
                        <div class="w-14 h-14 rounded-xl bg-white/5 flex items-center justify-center text-lg">📦</div>
                    @endif
                </div>
                <div class="flex-1">
                    <label class="block text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">Product Media</label>
                    <input type="file" name="product_image" 
                           class="block w-full text-[9px] text-slate-500 
                           file:mr-2 file:py-1 file:px-2 file:rounded-md file:border-0 
                           file:text-[9px] file:font-black file:uppercase 
                           file:bg-[#5046e5]/20 file:text-[#5046e5] 
                           hover:file:bg-[#5046e5] hover:file:text-white 
                           cursor-pointer transition-all">
                </div>
            </div>

            <div class="space-y-3">
                {{-- Name --}}
                <div>
                    <label class="block text-[9px] font-black text-[#5046e5] uppercase tracking-[0.2em] mb-1.5 ml-1">Title</label>
                    <input type="text" name="name" value="{{ $product->name }}" 
                           class="w-full bg-black/40 border border-white/5 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:ring-1 focus:ring-[#5046e5]/50 transition-all" required>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[9px] font-black text-[#5046e5] uppercase tracking-[0.2em] mb-1.5 ml-1">Category</label>
                        <div class="relative">
                            <select name="category_id" 
                                    class="w-full bg-black/40 border border-white/5 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:ring-1 focus:ring-[#5046e5]/50 appearance-none" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }} class="bg-[#0d0e14]">
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-[8px] text-slate-500">▼</div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[9px] font-black text-[#5046e5] uppercase tracking-[0.2em] mb-1.5 ml-1">Unit</label>
                        <input type="text" name="unit" value="{{ $product->unit }}" 
                               class="w-full bg-black/40 border border-white/5 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:ring-1 focus:ring-[#5046e5]/50" required placeholder="e.g. kg">
                    </div>
                </div>

                {{-- Price & Stock Grid --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[px] font-black font-semibold text-[#5046e5] uppercase tracking-[0.2em] mb-1.5 ml-1">Price (₱)</label>
                        <input type="number" name="price" step="0.01" value="{{ $product->price }}" 
                               class="w-full bg-black/40 border border-white/5 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:ring-1 focus:ring-[#5046e5]/50" required>
                    </div>
                    <div>
                        <label class="block text-[9px] font-black text-[#5046e5] uppercase tracking-[0.2em] mb-1.5 ml-1">Stock Level</label>
                        <input type="number" name="stock" value="{{ $product->stock }}" 
                               class="w-full bg-black/40 border border-white/5 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:ring-1 focus:ring-[#5046e5]/50" required>
                    </div>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-[#5046e5] to-[#3730a3] hover:brightness-110 text-white font-bold py-3 rounded-xl shadow-lg shadow-[#5046e5]/20 transition-all duration-300 uppercase text-[10px] tracking-[0.3em]">
                    Sync Changes
                </button>
            </div>
        </div>
    </form>
</div>
@endsection