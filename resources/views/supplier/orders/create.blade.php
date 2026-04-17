<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3 text-xs font-semibold uppercase tracking-widest text-slate-500">
            <span>Supplier System</span>
            <span class="text-slate-700">/</span>
            <span>Orders</span>
            <span class="text-slate-700">/</span>
            <span class="text-indigo-500">Create Requisition</span>
        </div>
    </x-slot>

    <div class="min-h-screen bg-slate-950 py-14 px-6">

        <div class="max-w-2xl mx-auto">

            {{-- Back Link --}}
            <div class="mb-10">
                <a href="{{ route('supplier.orders.index') }}"
                   class="text-xs font-semibold uppercase tracking-widest text-slate-400 hover:text-white transition">
                    ← Back to Orders
                </a>
            </div>

            {{-- Card --}}
            <div class="bg-white/5 border border-white/10 rounded-2xl shadow-xl overflow-hidden">

                <div class="p-10 md:p-12">

                    {{-- Title --}}
                    <div class="mb-10">
                        <h2 class="text-2xl font-semibold text-white">
                            New <span class="text-indigo-400">Requisition</span>
                        </h2>
                        <p class="text-xs text-slate-400 mt-2 tracking-wide">
                            Create a new supplier order request
                        </p>
                    </div>

                    {{-- Errors --}}
                    @if ($errors->any())
                        <div class="mb-8 bg-red-500/10 border border-red-500/30 rounded-lg p-4">
                            <p class="text-xs font-semibold text-red-400 uppercase tracking-wider mb-2">
                                Please fix the following errors:
                            </p>
                            <ul class="list-disc pl-5 space-y-1 text-sm text-red-300">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Form --}}
                    <form method="POST" action="{{ route('supplier.orders.store') }}" class="space-y-6">
                        @csrf

                        {{-- Product Name --}}
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">
                                Product Name
                            </label>
                            <input type="text" name="product_name"
                                   value="{{ old('product_name') }}"
                                   class="w-full rounded-lg bg-slate-900 border border-slate-700 text-white px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                                   placeholder="Enter product name" required>
                        </div>

                        {{-- Quantity + Priority --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                            <div>
                                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">
                                    Quantity
                                </label>
                                <input type="number" name="quantity"
                                       value="{{ old('quantity') }}"
                                       class="w-full rounded-lg bg-slate-900 border border-slate-700 text-white px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                                       placeholder="0" required>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">
                                    Priority
                                </label>
                                <select name="priority"
                                        class="w-full rounded-lg bg-slate-900 border border-slate-700 text-white px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                    <option value="standard">Standard</option>
                                    <option value="high">High</option>
                                    <option value="critical">Critical</option>
                                </select>
                            </div>

                        </div>

                        {{-- Notes --}}
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">
                                Notes (Optional)
                            </label>
                            <textarea name="notes" rows="3"
                                      class="w-full rounded-lg bg-slate-900 border border-slate-700 text-white px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none resize-none"
                                      placeholder="Additional instructions...">{{ old('notes') }}</textarea>
                        </div>

                        {{-- Buttons --}}
                        <div class="flex flex-col md:flex-row justify-between gap-4 pt-6 border-t border-slate-800">

                            <a href="{{ route('supplier.orders.index') }}"
                               class="text-sm text-slate-400 hover:text-white transition">
                                Cancel
                            </a>

                            <button type="submit"
                                    class="px-6 py-3 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg font-semibold transition">
                                Submit Requisition
                            </button>

                        </div>

                    </form>
                </div>

            </div>

            {{-- Footer Note --}}
            <p class="text-center text-xs text-slate-600 mt-8">
                Supplier Management System • Secure Data Entry Module
            </p>

        </div>
    </div>
</x-app-layout>