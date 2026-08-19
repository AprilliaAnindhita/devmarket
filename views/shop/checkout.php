<h1 class="font-display text-3xl font-extrabold tracking-tight text-ink-900">Checkout</h1>
<p class="mt-2 text-sm text-slate-500">Tinjau pesanan Anda dan tempatkan. Pembayaran disimulasikan — admin menandai pesanan sebagai dibayar untuk membuka unduhan.</p>

<div class="mt-8 grid grid-cols-1 gap-8 lg:grid-cols-3">
    <div class="space-y-4 lg:col-span-2">
        <div class="rounded-2xl bg-white p-6 shadow-card ring-1 ring-slate-200/70">
            <h2 class="font-display text-lg font-bold text-ink-900">Barang-barang</h2>
            <ul class="mt-4 divide-y divide-slate-100" data-testid="checkout-items">
                <?php foreach ($items as $it): $p = $it['product']; ?>
                <li class="flex items-center gap-4 py-3">
                    <img src="<?= e(thumb_url($p['thumbnail'])) ?>" alt="<?= e($p['title']) ?>" class="h-14 w-16 rounded-lg object-cover">
                    <div class="flex-1">
                        <p class="font-semibold text-ink-900"><?= e($p['title']) ?></p>
                        <p class="text-sm text-slate-500">Qty <?= $it['qty'] ?></p>
                    </div>
                    <span class="font-display font-bold text-ink-900"><?= money($it['line_total']) ?></span>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="rounded-2xl bg-brand-50 p-6 ring-1 ring-inset ring-brand-600/15">
            <div class="flex items-start gap-3">
                <span class="grid h-9 w-9 shrink-0 place-items-center rounded-full bg-brand-600 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                </span>
                <div>
                    <p class="font-semibold text-brand-900">Demo pembayaran</p>
                    <p class="mt-0.5 text-sm text-brand-700">Menempatkan pesanan ini membuat pesanan <strong>tertunda</strong>. Unduhan terbuka setelah ditandai dibayar.</p>
                </div>
            </div>
        </div>
    </div>

    <aside class="h-fit rounded-2xl bg-white p-6 shadow-card ring-1 ring-slate-200/70" data-testid="checkout-summary">
        <h2 class="font-display text-lg font-bold text-ink-900">Ringkasan</h2>
        <div class="mt-4 flex justify-between border-t border-slate-200 pt-4">
            <span class="font-display text-base font-bold text-ink-900">Total</span>
            <span class="font-display text-xl font-bold text-ink-900" data-testid="checkout-total"><?= money($total) ?></span>
        </div>
        <form method="POST" action="/checkout" class="mt-6">
            <button type="submit" class="w-full rounded-xl bg-brand-600 px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-brand-600/30 transition hover:bg-brand-500" data-testid="place-order-btn">Tempatkan pesanan</button>
        </form>
        <a href="/cart" class="mt-2 block text-center text-sm font-semibold text-slate-500 hover:text-slate-700">Kembali ke keranjang</a>
    </aside>
</div>
