<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <h1 class="font-display text-3xl font-extrabold tracking-tight text-ink-900">Kelola Produk</h1>
    <nav class="flex gap-1 rounded-xl bg-white p-1 shadow-card ring-1 ring-slate-200/70" data-testid="admin-nav">
        <a href="/admin" class="rounded-lg px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Ringkasan</a>
        <a href="/admin/products" class="rounded-lg bg-ink-900 px-4 py-2 text-sm font-semibold text-white">Produk</a>
        <a href="/admin/orders" class="rounded-lg px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Pesanan</a>
    </nav>
</div>

<div class="mt-6 flex justify-end">
    <a href="/admin/products/new" class="inline-flex w-fit shrink-0 items-center gap-2 whitespace-nowrap rounded-xl bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-brand-600/30 transition hover:bg-brand-500" data-testid="add-product-btn">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
        Tambah Produk
    </a>
</div>
<div class="mt-4 overflow-hidden rounded-2xl bg-white shadow-card ring-1 ring-slate-200/70">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100 text-sm" data-testid="products-table">
            <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-6 py-3.5">Produk</th>
                    <th class="px-6 py-3.5">Kategori</th>
                    <th class="px-6 py-3.5">Harga</th>
                    <th class="px-6 py-3.5">File</th>
                    <th class="px-6 py-3.5 text-right">Tindakan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php foreach ($products as $p): ?>
                <tr class="hover:bg-slate-50/60" data-testid="product-admin-row-<?= $p['id'] ?>">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <img src="<?= e(thumb_url($p['thumbnail'])) ?>" alt="" class="h-11 w-14 rounded-lg object-cover">
                            <span class="font-semibold text-ink-900"><?= e($p['title']) ?></span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-slate-600"><?= e($p['category_name']) ?></td>
                    <td class="px-6 py-4 font-semibold text-ink-900"><?= money($p['price']) ?></td>
                    <td class="px-6 py-4"><span class="rounded-md bg-slate-100 px-2 py-1 font-mono text-xs text-slate-600"><?= e($p['file_path'] ?: '—') ?></span></td>
                    <td class="px-6 py-4 text-right">
                        <form method="POST" action="/admin/products/delete" onsubmit="return confirm('Hapus produk ini?');">
                            <input type="hidden" name="id" value="<?= $p['id'] ?>">
                            <button type="submit" class="rounded-lg bg-rose-50 px-3 py-1.5 text-xs font-semibold text-rose-600 ring-1 ring-inset ring-rose-600/20 transition hover:bg-rose-100" data-testid="delete-product-<?= $p['id'] ?>">Hapus</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
