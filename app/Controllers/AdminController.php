<?php

class AdminController {
    public function dashboard(): void {
        Auth::requireAdmin();
        $stats = Order::stats();
        $recentOrders = array_slice(Order::allWithUser(), 0, 5);
        view('admin/dashboard', [
            'title'        => 'Dashboard Admin',
            'stats'        => $stats,
            'recentOrders' => $recentOrders,
        ]);
    }

    public function products(): void {
        Auth::requireAdmin();
        view('admin/products', ['title' => 'Kelola Produk', 'products' => Product::all()]);
    }

    public function productForm(): void {
        Auth::requireAdmin();
        view('admin/product_form', ['title' => 'Tambah Produk', 'categories' => Category::all()]);
    }

    public function storeProduct(): void {
        Auth::requireAdmin();

        $title = trim($_POST['title'] ?? '');
        $categoryId = (int)($_POST['category_id'] ?? 0);
        $price = (float)($_POST['price'] ?? 0);
        $description = trim($_POST['description'] ?? '');

        $errors = [];
        if ($title === '') $errors[] = 'Judul diperlukan.';
        if ($categoryId <= 0) $errors[] = 'Kategori diperlukan.';
        if ($price < 0) $errors[] = 'Harga harus nol atau lebih.';

        // Thumbnail upload (public)
        $thumbName = null;
        if (!empty($_FILES['thumbnail']['name']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                $errors[] = 'Thumbnail harus berupa gambar (jpg, png, webp, gif).';
            } else {
                $thumbName = 'thumb_' . time() . '_' . bin2hex(random_bytes(3)) . '.' . $ext;
                $dest = __DIR__ . '/../../public/uploads/thumbnails/' . $thumbName;
                if (!move_uploaded_file($_FILES['thumbnail']['tmp_name'], $dest)) {
                    $errors[] = 'Gagal mengunggah thumbnail.';
                    $thumbName = null;
                }
            }
        }

        // Digital file upload (protected storage)
        $fileName = null;
        if (!empty($_FILES['digital_file']['name']) && $_FILES['digital_file']['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($_FILES['digital_file']['name'], PATHINFO_EXTENSION));
            $fileName = Installer::slugify($title) . '_' . time() . '.' . $ext;
            $dest = __DIR__ . '/../../storage/downloads/' . $fileName;
            if (!move_uploaded_file($_FILES['digital_file']['tmp_name'], $dest)) {
                $errors[] = 'Gagal mengunggah file digital.';
                $fileName = null;
            }
        } else {
            $errors[] = 'File digital (aset yang diunduh pembeli) diperlukan.';
        }

        if ($errors) {
            flash('error', implode(' ', $errors));
            redirect('/admin/products/new');
        }

        $slug = Installer::slugify($title) . '-' . substr(bin2hex(random_bytes(2)), 0, 4);
        Product::create([
            'category_id' => $categoryId,
            'title'       => $title,
            'slug'        => $slug,
            'description' => $description,
            'price'       => $price,
            'thumbnail'   => $thumbName,
            'file_path'   => $fileName,
        ]);

        flash('success', 'Produk "' . $title . '" dibuat.');
        redirect('/admin/products');
    }

    public function deleteProduct(): void {
        Auth::requireAdmin();
        $id = (int)($_POST['id'] ?? 0);
        Product::delete($id);
        flash('success', 'Produk dihapus.');
        redirect('/admin/products');
    }

    public function orders(): void {
        Auth::requireAdmin();
        $orders = array_map(function ($o) {
            $o['items'] = Order::items((int)$o['id']);
            return $o;
        }, Order::allWithUser());
        view('admin/orders', ['title' => 'Manage Orders', 'orders' => $orders]);
    }

    public function markPaid(): void {
        Auth::requireAdmin();
        $id = (int)($_POST['id'] ?? 0);
        $order = Order::find($id);
        if ($order) {
            Order::markPaid($id);
            flash('success', 'Order ' . $order['order_number'] . ' marked as PAID. Buyer can now download.');
        }
        redirect('/admin/orders');
    }
}
