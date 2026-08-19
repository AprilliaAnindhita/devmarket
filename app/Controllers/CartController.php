<?php

class CartController {
    public function add(): void {
        $productId = (int)($_POST['product_id'] ?? 0);
        $product = Product::find($productId);
        if (!$product) {
            flash('error', 'Produk tidak ditemukan.');
            redirect('/');
        }
        $cart = cart();
        if (isset($cart[$productId])) {
            $cart[$productId]['qty'] += 1;
        } else {
            $cart[$productId] = ['qty' => 1, 'price' => (float)$product['price']];
        }
        $_SESSION['cart'] = $cart;
        flash('success', '"' . $product['title'] . '" ditambahkan ke keranjang.');
        redirect($_POST['redirect'] ?? '/cart');
    }

    public function view(): void {
        $items = [];
        $total = 0.0;
        foreach (cart() as $pid => $line) {
            $product = Product::find((int)$pid);
            if (!$product) continue;
            $lineTotal = (float)$product['price'] * (int)$line['qty'];
            $total += $lineTotal;
            $items[] = ['product' => $product, 'qty' => (int)$line['qty'], 'line_total' => $lineTotal];
        }
        view('shop/cart', ['title' => 'Keranjang Anda', 'items' => $items, 'total' => $total]);
    }

    public function remove(): void {
        $productId = (int)($_POST['product_id'] ?? 0);
        $cart = cart();
        unset($cart[$productId]);
        $_SESSION['cart'] = $cart;
        flash('success', 'Item dihapus dari keranjang.');
        redirect('/cart');
    }
}
