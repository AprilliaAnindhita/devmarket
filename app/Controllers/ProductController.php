<?php

class ProductController {
    public function index(): void {
        $search = trim($_GET['q'] ?? '');
        $category = trim($_GET['category'] ?? '');
        $sort = trim($_GET['sort'] ?? '');

        $products = Product::query($search, $category, $sort);
        $categories = Category::all();

        view('shop/home', [
            'title'      => 'DevMarket — Aset Digital Premium',
            'products'   => $products,
            'categories' => $categories,
            'search'     => $search,
            'activeCat'  => $category,
            'sort'       => $sort,
        ]);
    }

    public function show(string $slug): void {
        $product = Product::findBySlug($slug);
        if (!$product) {
            http_response_code(404);
            flash('error', 'Produk tidak ditemukan.');
            redirect('/');
        }
        $related = Product::related((int)$product['category_id'], (int)$product['id']);
        view('shop/product', [
            'title'   => $product['title'],
            'product' => $product,
            'related' => $related,
        ]);
    }
}
