<div class="mx-auto max-w-2xl">
    <div class="flex items-center gap-3">
        <a href="/admin/products" class="rounded-lg bg-white p-2 text-slate-500 shadow-card ring-1 ring-slate-200/70 transition hover:text-slate-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/></svg>
        </a>
        <h1 class="font-display text-2xl font-bold text-ink-900">Tambah Produk Baru</h1>
    </div>

    <form method="POST" action="/admin/products" enctype="multipart/form-data" class="mt-6 space-y-5 rounded-2xl bg-white p-6 shadow-card ring-1 ring-slate-200/70" data-testid="product-form">
        <div>
            <label class="mb-1.5 block text-sm font-semibold text-slate-700">Judul</label>
            <input type="text" name="title" required class="w-full rounded-xl border-0 bg-slate-50 px-4 py-3 text-sm ring-1 ring-inset ring-slate-200 focus:bg-white focus:ring-2 focus:ring-brand-500" data-testid="product-title-input" placeholder="Mis. React Dashboard Kit">
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
                <label class="mb-1.5 block text-sm font-semibold text-slate-700">Kategori</label>
                <select name="category_id" required class="w-full rounded-xl border-0 bg-slate-50 px-4 py-3 text-sm ring-1 ring-inset ring-slate-200 focus:bg-white focus:ring-2 focus:ring-brand-500" data-testid="product-category-input">
                    <option value="">Pilih kategori</option>
                    <?php foreach ($categories as $c): ?>
                        <option value="<?= $c['id'] ?>"><?= e($c['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-semibold text-slate-700">Harga (IDR)</label>
                <input type="number" name="price" step="1" min="0" required class="w-full rounded-xl border-0 bg-slate-50 px-4 py-3 text-sm ring-1 ring-inset ring-slate-200 focus:bg-white focus:ring-2 focus:ring-brand-500" data-testid="product-price-input" placeholder="50000">
            </div>
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-semibold text-slate-700">Deskripsi</label>
            <textarea name="description" rows="4" class="w-full rounded-xl border-0 bg-slate-50 px-4 py-3 text-sm ring-1 ring-inset ring-slate-200 focus:bg-white focus:ring-2 focus:ring-brand-500" data-testid="product-description-input" placeholder="Apa yang termasuk dalam aset ini..."></textarea>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
                <label class="mb-1.5 block text-sm font-semibold text-slate-700">Gambar thumbnail</label>
                <input type="file" name="thumbnail" accept="image/*" class="w-full rounded-xl border border-dashed border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-brand-600 file:px-3 file:py-1.5 file:text-white" data-testid="product-thumbnail-input">
                <p class="mt-1 text-xs text-slate-400">Diunggah ke public/uploads/thumbnails/</p>
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-semibold text-slate-700">File digital (dilindungi)</label>
                <input type="file" name="digital_file" required class="w-full rounded-xl border border-dashed border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-ink-900 file:px-3 file:py-1.5 file:text-white" data-testid="product-file-input">
                <p class="mt-1 text-xs text-slate-400">Disimpan di storage/downloads/ (tidak dapat diakses web)</p>
            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="rounded-xl bg-brand-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-brand-600/30 transition hover:bg-brand-500" data-testid="save-product-btn">Simpan produk</button>
            <a href="/admin/products" class="rounded-xl bg-slate-100 px-6 py-3 text-sm font-semibold text-slate-700 ring-1 ring-inset ring-slate-200 transition hover:bg-slate-200">Batal</a>
        </div>
    </form>
</div>
