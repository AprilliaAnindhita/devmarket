<?php

class OrderController {
    public function checkout(): void {
        Auth::requireLogin();
        $items = [];
        $total = 0.0;
        foreach (cart() as $pid => $line) {
            $product = Product::find((int)$pid);
            if (!$product) continue;
            $lineTotal = (float)$product['price'] * (int)$line['qty'];
            $total += $lineTotal;
            $items[] = ['product' => $product, 'qty' => (int)$line['qty'], 'line_total' => $lineTotal];
        }
        if (!$items) {
            flash('error', 'Keranjang Anda kosong.');
            redirect('/cart');
        }
        view('shop/checkout', ['title' => 'Checkout', 'items' => $items, 'total' => $total]);
    }

    public function placeOrder(): void {
        Auth::requireLogin();
        $items = [];
        foreach (cart() as $pid => $line) {
            $product = Product::find((int)$pid);
            if (!$product) continue;
            $items[(int)$pid] = ['qty' => (int)$line['qty'], 'price' => (float)$product['price']];
        }
        if (!$items) {
            flash('error', 'Keranjang Anda kosong.');
            redirect('/cart');
        }
        $orderId = Order::createForItems((int)Auth::id(), $items);
        $_SESSION['cart'] = [];
        $order = Order::find($orderId);
        flash('success', 'Pesanan ' . $order['order_number'] . ' ditempatkan! Sedang menunggu pembayaran. Admin dapat menandai sebagai dibayar untuk membuka unduhan.');
        redirect('/dashboard');
    }

    public function dashboard(): void {
        Auth::requireLogin();
        $userId = (int)Auth::id();
        $orders = Order::forUser($userId);
        $ordersWithItems = array_map(function ($o) {
            $o['items'] = Order::items((int)$o['id']);
            return $o;
        }, $orders);
        $downloads = Order::paidProductsForUser($userId);
        view('user/dashboard', [
            'title'     => 'Dashboard Saya',
            'orders'    => $ordersWithItems,
            'downloads' => $downloads,
        ]);
    }
}
