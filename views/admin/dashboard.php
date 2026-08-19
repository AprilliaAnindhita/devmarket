<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <h1 class="font-display text-3xl font-extrabold tracking-tight text-ink-900">Dashboard Admin</h1>
    <nav class="flex gap-1 rounded-xl bg-white p-1 shadow-card ring-1 ring-slate-200/70" data-testid="admin-nav">
        <a href="/admin" class="rounded-lg bg-ink-900 px-4 py-2 text-sm font-semibold text-white">Ringkasan</a>
        <a href="/admin/products" class="rounded-lg px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Produk</a>
        <a href="/admin/orders" class="rounded-lg px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Pesanan</a>
    </nav>
</div>

<div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-3" data-testid="stat-cards">
    <?php
    $cards = [
        ['label' => 'Total Penjualan', 'value' => money($stats['total_sales']), 'sub' => $stats['paid_orders'] . ' pesanan dibayar', 'accent' => 'from-emerald-500 to-teal-600', 'icon' => 'M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33'],
        ['label' => 'Total Pesanan', 'value' => (string)$stats['total_orders'], 'sub' => 'Sepanjang waktu', 'accent' => 'from-brand-500 to-indigo-600', 'icon' => 'M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007Z'],
        ['label' => 'Total Produk', 'value' => (string)$stats['total_products'], 'sub' => 'Di katalog', 'accent' => 'from-amber-500 to-orange-600', 'icon' => 'm21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9'],
    ];
    foreach ($cards as $c): ?>
    <div class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-card ring-1 ring-slate-200/70">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm font-semibold text-slate-500"><?= $c['label'] ?></p>
                <p class="mt-2 font-display text-3xl font-extrabold text-ink-900"><?= $c['value'] ?></p>
                <p class="mt-1 text-xs text-slate-400"><?= $c['sub'] ?></p>
            </div>
            <span class="grid h-11 w-11 place-items-center rounded-xl bg-gradient-to-br <?= $c['accent'] ?> text-white shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="<?= $c['icon'] ?>"/></svg>
            </span>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div class="mt-8 rounded-2xl bg-white shadow-card ring-1 ring-slate-200/70">
    <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
            <h2 class="font-display text-lg font-bold text-ink-900">Pesanan Terbaru</h2>
            <a href="/admin/orders" class="text-sm font-semibold text-brand-600 hover:text-brand-700">Lihat semua →</a>
        </div>
        <?php if (!$recentOrders): ?>
            <p class="px-6 py-10 text-center text-sm text-slate-500">Belum ada pesanan.</p>
        <?php else: ?>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr><th class="px-6 py-3">Pesanan #</th><th class="px-6 py-3">Pelanggan</th><th class="px-6 py-3">Total</th><th class="px-6 py-3">Status</th></tr>
                <?php foreach ($recentOrders as $o): ?>
                <tr>
                    <td class="px-6 py-3.5 font-mono text-xs font-semibold text-ink-900"><?= e($o['order_number']) ?></td>
                    <td class="px-6 py-3.5 text-slate-600"><?= e($o['user_name']) ?></td>
                    <td class="px-6 py-3.5 font-semibold text-ink-900"><?= money($o['total_amount']) ?></td>
                    <td class="px-6 py-3.5"><?= status_badge($o['payment_status']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>
