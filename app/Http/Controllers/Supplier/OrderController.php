<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Category;
use App\Models\Activity; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ORDERS INDEX (Supplier)
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = Order::where('user_id', Auth::id())
            ->with(['items.product']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(10);

        return view('supplier.orders.index', compact('orders'));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE ORDER PAGE
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $categories = Category::with('products')->get();

        return view('supplier.orders.create', compact('categories'));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE ORDER (CHECKOUT)
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $cartData = json_decode($request->input('cart_data'), true);
        $notes = $request->input('notes', '');

        if (!$cartData || !is_array($cartData) || count($cartData) === 0) {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }

        $total = 0;
        $totalQuantity = 0;
        $orderItems = [];

        foreach ($cartData as $item) {

            $product = Product::find($item['id'] ?? $item['product_id']);

            if (!$product) continue;

            $qty = (int) ($item['qty'] ?? 1);
            $subtotal = $product->price * $qty;

            $total += $subtotal;
            $totalQuantity += $qty;

            $orderItems[] = [
                'product_id' => $product->id,
                'quantity'   => $qty,
                'price'      => $product->price,
                'subtotal'   => $subtotal,
            ];
        }

        if (count($orderItems) === 0) {
            return back()->with('error', 'No valid products in cart.');
        }

        $order = Order::create([
            'user_id'       => Auth::id(),
            'supplier_id'   => Auth::user()->supplier_id ?? null,
            'order_number'  => 'ORD-' . strtoupper(Str::random(8)),
            'status'        => 'Pending',
            'notes'         => $notes,
            'total_amount'  => $total,
            'quantity'      => $totalQuantity,
        ]);

        foreach ($orderItems as $item) {
            $item['order_id'] = $order->id;
            OrderItem::create($item);
        }

        session()->forget('cart');

        Activity::create([
            'user_id'     => Auth::id(),
            'type'        => 'order',
            'title'       => 'Order Created',
            'description' => "Order {$order->order_number} was placed successfully.",
            'status'      => 'Pending',
            'amount'      => $total,
        ]);

        return redirect()
            ->route('supplier.orders.index')
            ->with('success', "Order {$order->order_number} placed successfully!");
    }

    /*
    |--------------------------------------------------------------------------
    | CART - ADD ITEM
    |--------------------------------------------------------------------------
    */
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['qty'] += $request->quantity;
        } else {
            $cart[$product->id] = [
                'id'    => $product->id,
                'name'  => $product->name,
                'price' => $product->price,
                'image' => $product->image_path,
                'qty'   => $request->quantity
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Added to cart.');
    }

    public function cart()
    {
        return view('supplier.orders.cart', [
            'cart' => session('cart', [])
        ]);
    }

    public function checkout(Request $request)
    {
        return $this->store($request);
    }

    public function adminIndex()
    {
        $orders = Order::with(['user', 'supplier', 'items.product'])
            ->latest()
            ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:Pending,Processing,Shipped,Delivered,Rejected'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        Activity::create([
            'user_id'     => Auth::id(),
            'type'        => 'order',
            'title'       => 'Order Updated',
            'description' => "Order {$order->order_number} changed to {$request->status}.",
            'status'      => $request->status,
        ]);

        return back()->with('success', 'Order updated.');
    }

    /*
    |--------------------------------------------------------------------------
    | APPROVE ORDER
    |--------------------------------------------------------------------------
    */
    public function approve(Order $order)
    {
        $order->update([
            'approval_status' => 'Approved',
            'status' => 'Processing'
        ]);

        Activity::create([
            'user_id'     => Auth::id(),
            'type'        => 'order',
            'title'       => 'Order Approved',
            'description' => "Order {$order->order_number} was approved.",
            'status'      => 'Approved',
        ]);

        return back()->with('success', 'Order approved.');
    }

    /*
    |--------------------------------------------------------------------------
    | REJECT ORDER
    |--------------------------------------------------------------------------
    */
    public function reject(Order $order)
    {
        $order->update([
            'approval_status' => 'Rejected',
            'status' => 'Rejected'
        ]);

        Activity::create([
            'user_id'     => Auth::id(),
            'type'        => 'order',
            'title'       => 'Order Rejected',
            'description' => "Order {$order->order_number} was rejected.",
            'status'      => 'Rejected',
        ]);

        return back()->with('success', 'Order rejected.');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE ORDER
    |--------------------------------------------------------------------------
    */
    public function destroy(Order $order)
    {
        $orderNumber = $order->order_number;
        $order->delete();

        Activity::create([
            'user_id'     => Auth::id(),
            'type'        => 'order',
            'title'       => 'Order Deleted',
            'description' => "Order {$orderNumber} was deleted.",
            'status'      => 'Deleted',
        ]);

        return back()->with('success', 'Order deleted.');
    }
}