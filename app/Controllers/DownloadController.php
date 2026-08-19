<?php

class DownloadController {
    /**
     * Secure download engine.
     * Serves the protected file only when the logged-in buyer owns a PAID order for it.
     */
    public function download(string $id): void {
        Auth::requireLogin();
        $productId = (int)$id;
        $product = Product::find($productId);
        if (!$product) {
            http_response_code(404);
            flash('error', 'Produk tidak ditemukan.');
            redirect('/dashboard');
        }

        if (!Order::userHasPaidProduct((int)Auth::id(), $productId)) {
            http_response_code(403);
            flash('error', 'Akses ditolak. Anda memerlukan pesanan berbayar untuk produk ini untuk mengunduhnya.');
            redirect('/dashboard');
        }

        $storageDir = realpath(__DIR__ . '/../../storage/downloads');
        $filePath = $storageDir . DIRECTORY_SEPARATOR . basename($product['file_path']);

        if (!$product['file_path'] || !is_file($filePath)) {
            http_response_code(404);
            flash('error', 'File untuk produk ini tidak tersedia.');
            redirect('/dashboard');
        }

        // Clean any buffered output before streaming the binary
        while (ob_get_level() > 0) ob_end_clean();

        $downloadName = Installer::slugify($product['title']) . '.' . pathinfo($filePath, PATHINFO_EXTENSION);

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $downloadName . '"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    }
}
