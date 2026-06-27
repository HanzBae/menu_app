<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Menu;
use App\Models\OrderItem;

class OrderController extends Controller
{
    // === WEB (Owner - Pesanan Masuk, butuh login) ===
    public function viewCart()
    {
        $orders = Order::with('items.menu')->latest()->get();
        return view('owner.orders.index', compact('orders'));
    }

    public function showWeb(Order $order)
    {
        return view('order.show', compact('order'));
    }

    public function addToCart(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        $cart[$id] = min(($cart[$id] ?? 0) + 1, 5);
        session(['cart' => $cart]);
        return response()->json($cart);
    }

    public function minusFromCart(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        $cart[$id] = max(0, ($cart[$id] ?? 0) - 1);
        session(['cart' => $cart]);
        return response()->json($cart);
    }

    public function resetCart()
    {
        session()->forget('cart');
        return response()->json(['message' => 'Keranjang direset']);
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return response()->json(['error' => 'Keranjang kosong'], 400);
        }

        $customerName = $request->input('customer_name', 'Guest');
        $total = 0;
        $items = [];

        foreach ($cart as $menuId => $qty) {
            if ($qty > 0) {
                $menu = Menu::findOrFail($menuId);
                $subtotal = $menu->price * $qty;
                $total += $subtotal;
                $items[] = [
                    'menu_id' => $menu->id,
                    'quantity' => $qty,
                    'price' => $menu->price,
                ];
            }
        }

        $order = Order::create([
            'customer_name' => $customerName,
            'total_price' => $total,
            'status' => 'pending',
        ]);

        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $item['menu_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        session()->forget('cart');
        return response()->json(['message' => 'Pesanan berhasil', 'order_id' => $order->id]);
    }

    public function completeOrder(Request $request, Order $order)
    {
        $order->update(['status' => 'completed']);
        return response()->json(['message' => 'Pesanan selesai!']);
    }

    // === REST API ===
    public function index()
    {
        return response()->json(Order::with('items.menu')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.menu_id' => 'required|exists:menus,id',
            'items.*.quantity' => 'required|integer|min:1|max:10',
        ]);

        $items = [];
        $total = 0;
        foreach ($request->items as $item) {
            $menu = Menu::findOrFail($item['menu_id']);
            $subtotal = $menu->price * $item['quantity'];
            $total += $subtotal;
            $items[] = [
                'menu_id' => $menu->id,
                'quantity' => $item['quantity'],
                'price' => $menu->price,
            ];
        }

        $order = Order::create([
            'customer_name' => $request->customer_name ?? 'Guest',
            'total_price' => $total,
            'status' => 'pending',
        ]);

        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $item['menu_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        return response()->json($order->load('items.menu'), 201);
    }

    public function show(Order $order)
    {
        return response()->json($order->load('items.menu'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:pending,completed']);
        $order->update(['status' => $request->status]);
        return response()->json($order);
    }

    public function destroy(Order $order)
    {
        $order->items()->delete();
        $order->delete();
        return response()->json(null, 204);
    }
}