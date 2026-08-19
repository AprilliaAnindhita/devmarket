<h1 class="font-display text-3xl font-extrabold tracking-tight text-ink-900">Keranjang Anda</h1>

<?php if (!$items): ?>
    <div class="mt-8 grid place-items-center rounded-2xl border border-dashed border-slate-300 bg-white py-20 text-center" data-testid="empty-cart">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272"/></svg>
        <p class="mt-4 text-lg font-semibold text-slate-700">Keranjang Anda kosong</p>
        <a href="/" class="mt-4 rounded-xl bg-brand-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-brand-600/30 transition hover:bg-brand-500" data-testid="browse-btn">Jelajahi aset</a>
    </div>
<?php else: ?>
    <div class="mt-8 grid grid-cols-1 gap-8 lg:grid-cols-3">
        <div class="space-y-4 lg:col-span-2" data-testid="cart-items">
            <?php foreach ($items as $it): $p = $it['product']; ?>
            <div class="flex items-center gap-4 rounded-2xl bg-white p-4 shadow-card ring-1 ring-slate-200/70" data-testid="cart-item-<?= $p['id'] ?>">
                <img src="<?= e(thumb_url($p['thumbnail'])) ?>" alt="<?= e($p['title']) ?>" class="h-20 w-24 shrink-0 rounded-xl object-cover">
                <div class="min-w-0 flex-1">
                    <a href="/product/<?= e($p['slug']) ?>" class="font-display font-bold text-ink-900 hover:text-brand-600"><?= e($p['title']) ?></a>
                    <p class="text-sm text-slate-500">Qty: <?= $it['qty'] ?> · <?= money($p['price']) ?> setiap satu</p>
                </div>
                <div class="text-right">
                    <p class="font-display text-lg font-bold text-ink-900"><?= money($it['line_total']) ?></p>
                    <form method="POST" action="/cart/remove">
                        <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                        <button type="submit" class="mt-1 text-xs font-semibold text-rose-600 hover:text-rose-700" data-testid="remove-item-<?= $p['id'] ?>">Hapus</button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <aside class="h-fit rounded-2xl bg-white p-6 shadow-card ring-1 ring-slate-200/70" data-testid="cart-summary">
            <h2 class="font-display text-lg font-bold text-ink-900">Ringkasan Pesanan</h2>
            <dl class="mt-4 space-y-2.5 text-sm">
                <div class="flex justify-between text-slate-600"><dt>Subtotal</dt><dd class="font-semibold text-slate-800"><?= money($total) ?></dd></div>
                <div class="flex justify-between text-slate-600"><dt>Pemrosesan</dt><dd class="font-semibold text-emerald-600">Gratis</dd></div>
                <div class="mt-3 flex justify-between border-t border-slate-200 pt-3">
                    <dt class="font-display text-base font-bold text-ink-900">Total</dt>
                    <dd class="font-display text-xl font-bold text-ink-900" data-testid="cart-total"><?= money($total) ?></dd>
                </div>
            </dl>
            <a href="/checkout" class="mt-6 block rounded-xl bg-brand-600 px-6 py-3.5 text-center text-sm font-semibold text-white shadow-lg shadow-brand-600/30 transition hover:bg-brand-500" data-testid="checkout-btn">Lanjutkan ke checkout</a>
            <a href="/" class="mt-2 block text-center text-sm font-semibold text-slate-500 hover:text-slate-700">Lanjutkan berbelanja</a>
        </aside>
    </div>
<?php endif; ?>
