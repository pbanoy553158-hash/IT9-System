<x-app-layout>

<div class="py-6 px-4 sm:px-6 lg:px-8 text-white">

    <div class="max-w-7xl mx-auto space-y-8">

        <div>
            <a href="{{ route('supplier.orders.index') }}"
               class="text-xs text-slate-400 hover:text-white flex items-center gap-1 mb-4">
                ← Back to Orders
            </a>

            <div class="flex justify-between items-center">
                <h1 class="text-xl font-bold">Create New Order</h1>
                <button onclick="openCart()"
                    class="relative bg-indigo-600 hover:bg-indigo-500 px-4 py-2 rounded-lg text-xs font-bold flex items-center gap-2">

                    🛒 Cart
                    <span id="cartCount"
                          class="bg-black/40 px-2 py-0.5 rounded-full text-[10px] min-w-[18px] text-center">
                        0
                    </span>
                </button>
            </div>
        </div>

        {{-- PRODUCTS --}}
        @foreach($categories as $category)
        <div>

            <div class="mb-4">
                <h2 class="text-sm font-semibold text-indigo-300">
                    {{ $category->name }}
                </h2>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                @foreach($category->products as $product)
                <div class="bg-[#0f0f15] border border-white/10 rounded-xl p-3 hover:border-indigo-500/30 transition">

                    <div class="h-44 bg-black rounded-lg overflow-hidden mb-3 flex items-center justify-center p-2">

                        @if($product->image_path)
                            <img src="{{ asset('storage/'.$product->image_path) }}"
                                 class="max-h-full max-w-full object-contain">
                        @else
                            <span class="text-[10px] text-slate-600">No Image</span>
                        @endif

                    </div>

                    <div class="text-white font-medium text-sm mb-1 truncate">
                        {{ $product->name }}
                    </div>

                    <div class="text-emerald-400 font-bold text-sm mb-3">
                        ₱{{ number_format($product->price, 2) }}
                    </div>

                    <div class="flex items-center justify-between">

                        <div class="flex items-center gap-3">

                            <button onclick="dec({{ $product->id }})"
                                class="text-white text-lg hover:text-indigo-400 transition">-</button>

                            <span id="qty-{{ $product->id }}" class="text-white text-sm w-6 text-center">1</span>

                            <button onclick="inc({{ $product->id }})"
                                class="text-white text-lg hover:text-indigo-400 transition">+</button>
                        </div>

                        {{-- CART ICON --}}
                        <button onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, '{{ $product->image_path }}')"
                            class="text-indigo-400 hover:text-indigo-300 text-lg transition">
                            🛒
                        </button>

                    </div>

                </div>
                @endforeach

            </div>
        </div>
        @endforeach

    </div>
</div>

{{-- CART MODAL --}}
<div id="cartModal" class="hidden fixed inset-0 bg-black/80 flex items-center justify-center z-50">

    <div class="bg-[#0f0f15] w-full max-w-md mx-4 rounded-2xl border border-white/10 p-5 space-y-4">

        <div class="flex justify-between items-center">
            <h2 class="text-white font-bold text-lg">Cart</h2>
            <button onclick="closeCart()" class="text-slate-400 hover:text-white text-xl">×</button>
        </div>

        <div id="cartItems" class="space-y-2 max-h-64 overflow-y-auto pr-1"></div>

        <div class="flex justify-between text-white border-t border-white/10 pt-3">
            <span class="text-sm">Total</span>
            <span class="font-bold text-base" id="cartTotal">₱0.00</span>
        </div>

        <form method="POST" action="{{ route('supplier.cart.checkout') }}">
            @csrf

            <input type="hidden" name="cart_data" id="cartData">

            <div class="flex gap-2">
                <button type="button" onclick="closeCart()"
                    class="flex-1 py-2 text-slate-400 border border-white/10 rounded-xl text-xs hover:bg-white/5">
                    Cancel
                </button>

                <button type="submit" onclick="prepareCheckout()"
                    class="flex-1 bg-indigo-600 hover:bg-indigo-500 py-2 rounded-xl text-xs font-bold">
                    Checkout
                </button>
            </div>

        </form>

    </div>
</div>

{{-- SCRIPT --}}
<script>
    let cart = {};

    function inc(id) {
        document.getElementById('qty-' + id).innerText =
            parseInt(document.getElementById('qty-' + id).innerText) + 1;
    }

    function dec(id) {
        let el = document.getElementById('qty-' + id);
        if (parseInt(el.innerText) > 1) {
            el.innerText = parseInt(el.innerText) - 1;
        }
    }

    function addToCart(id, name, price, image) {
        let qty = parseInt(document.getElementById('qty-' + id).innerText);

        if (cart[id]) {
            cart[id].qty += qty;
        } else {
            cart[id] = { id, name, price, qty, image };
        }

        document.getElementById('qty-' + id).innerText = 1;

        updateCartCount();
        showToast("Added successfully ✔");
    }

    function updateCartCount() {
        let count = Object.values(cart).reduce((a, b) => a + b.qty, 0);
        document.getElementById('cartCount').innerText = count;
    }

    function openCart() {
        updateCart();
        document.getElementById('cartModal').classList.remove('hidden');
    }

    function closeCart() {
        document.getElementById('cartModal').classList.add('hidden');
    }

    function updateCart() {
        let container = document.getElementById('cartItems');
        container.innerHTML = '';

        let total = 0;

        Object.values(cart).forEach(item => {
            total += item.price * item.qty;

            container.innerHTML += `
                <div class="flex items-center gap-3 p-3">

                    <div class="h-10 w-10 bg-black rounded-md overflow-hidden flex-shrink-0">
                        ${item.image ? `<img src="/storage/${item.image}" class="w-full h-full object-cover">` : ''}
                    </div>

                    <div class="flex-1">
                        <div class="text-white text-sm">${item.name}</div>
                        <div class="text-xs text-slate-400">₱${item.price} × ${item.qty}</div>
                    </div>

                    <div class="text-right">
                        <div class="text-white font-bold text-sm">₱${(item.price * item.qty).toFixed(2)}</div>
                        <button onclick="removeItem(${item.id})" class="text-red-400 text-xs">Remove</button>
                    </div>

                </div>
            `;
        });

        if (Object.keys(cart).length === 0) {
            container.innerHTML = `<p class="text-slate-500 text-center py-6">Cart empty</p>`;
        }

        document.getElementById('cartTotal').innerText = '₱' + total.toFixed(2);
    }

    function removeItem(id) {
        delete cart[id];
        updateCart();
        updateCartCount();
    }

    function prepareCheckout() {
        document.getElementById('cartData').value = JSON.stringify(cart);
    }

    function showToast(msg) {
        const t = document.createElement('div');
        t.className = 'fixed bottom-6 right-6 bg-indigo-600 text-white text-xs px-4 py-2 rounded-xl';
        t.innerText = msg;
        document.body.appendChild(t);

        setTimeout(() => {
            t.style.opacity = '0';
            setTimeout(() => t.remove(), 300);
        }, 2000);
    }
</script>

</x-app-layout>