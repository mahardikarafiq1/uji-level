<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Seat;
use App\Models\Setting;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $seats = Seat::orderBy('seat_code')->get();
        return view('cart', compact('seats'));
    }

    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'payment_method' => 'required|in:whatsapp,qris',
            'order_type'     => 'required|in:dine_in,take_away',
            'seat_code'      => 'nullable|string|max:10',
            'notes'          => 'nullable|string|max:1000',
            'items'          => 'required|string', // JSON string
        ]);

        $items = json_decode($validated['items'], true);

        if (empty($items)) {
            return back()->with('error', 'Keranjang kosong!');
        }

        // Calculate total and validate products (with flash sale pricing)
        $totalAmount = 0;
        $orderItems = [];
        $totalItemsQty = 0;

        foreach ($items as $item) {
            $product = Product::find($item['product_id']);
            if (! $product || ! $product->is_available) {
                continue;
            }

            $qty = max(1, (int) $item['quantity']);
            $unitPrice = $product->effective_price; // Uses flash sale price if active
            $subtotal = $unitPrice * $qty;
            $totalAmount += $subtotal;
            $totalItemsQty += $qty;

            $orderItems[] = [
                'product_id' => $product->id,
                'quantity'   => $qty,
                'unit_price' => $unitPrice,
                'subtotal'   => $subtotal,
            ];
        }

        if (empty($orderItems)) {
            return back()->with('error', 'Tidak ada produk valid dalam pesanan.');
        }

        // Loyalty Discount: Buy 10 get 1 free (cheapest item free)
        $user = auth()->user();
        $loyaltyDiscount = 0;
        $freeItemName = null;

        if ($user && $totalItemsQty >= 10) {
            // Find cheapest item to give free
            $cheapest = collect($orderItems)->sortBy('unit_price')->first();
            $loyaltyDiscount = $cheapest['unit_price'];
            $totalAmount -= $loyaltyDiscount;
            $freeItemName = Product::find($cheapest['product_id'])?->name;
        }

        // Ensure total is not negative
        $totalAmount = max(0, $totalAmount);

        // Create order
        $order = Order::create([
            'order_code'     => Order::generateOrderCode(),
            'user_id'        => auth()->id(),
            'customer_name'  => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'total_amount'   => $totalAmount,
            'status'         => 'pending',
            'order_type'     => $validated['order_type'],
            'payment_method' => $validated['payment_method'],
            'seat_code'      => $validated['order_type'] === 'dine_in' ? ($validated['seat_code'] ?? null) : null,
            'notes'          => $validated['notes'] ?? null,
        ]);

        // Create order items
        foreach ($orderItems as $oi) {
            $order->items()->create($oi);
        }

        // Update user loyalty points
        if ($user) {
            $user->increment('loyalty_points', $totalItemsQty);
        }

        // Reload with items
        $order->load('items.product');

        // If WhatsApp, build WA redirect URL
        if ($validated['payment_method'] === 'whatsapp') {
            $waNumber = Setting::getValue('whatsapp_number', '');
            if (empty($waNumber)) {
                return back()->with('error', 'Fitur Checkout WhatsApp saat ini dinonaktifkan karena admin belum mendaftarkan nomor tujuan.');
            }

            $waMessage = $this->buildWhatsAppMessage($order);
            $waUrl = 'https://wa.me/' . $waNumber . '?text=' . urlencode($waMessage);

            return redirect()->route('order.confirmation', $order->order_code)
                ->with('wa_url', $waUrl);
        }

        return redirect()->route('order.confirmation', $order->order_code);
    }

    public function confirmation(string $orderCode)
    {
        $order = Order::where('order_code', $orderCode)
            ->with('items.product')
            ->firstOrFail();

        $qrisImage = Setting::getValue('qris_image', '');
        $waNumber = Setting::getValue('whatsapp_number', '');

        return view('order-confirmation', compact('order', 'qrisImage', 'waNumber'));
    }

    private function buildWhatsAppMessage(Order $order): string
    {
        $lines = [];
        $lines[] = "🛒 *Pesanan Baru - Felize Cafe*";
        $lines[] = "📋 Order: {$order->order_code}";
        $lines[] = "";
        $lines[] = "*Items:*";

        foreach ($order->items as $item) {
            $subtotal = number_format($item->subtotal, 0, ',', '.');
            $lines[] = "• {$item->product->name} x{$item->quantity} — Rp {$subtotal}";
        }

        $lines[] = "";
        $total = number_format($order->total_amount, 0, ',', '.');
        $lines[] = "💰 *Total: Rp {$total}*";
        $lines[] = "👤 Nama: {$order->customer_name}";
        $lines[] = "📱 WA: {$order->customer_phone}";

        if ($order->seat_code) {
            $lines[] = "🪑 Meja: {$order->seat_code}";
        }

        if ($order->notes) {
            $lines[] = "📝 Catatan: {$order->notes}";
        }

        $lines[] = "";
        $lines[] = "Metode Bayar: " . ($order->payment_method === 'whatsapp' ? 'Transfer (WhatsApp)' : 'QRIS');

        return implode("\n", $lines);
    }
}
