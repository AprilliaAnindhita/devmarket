<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <h1 class="font-display text-3xl font-extrabold tracking-tight text-ink-900">Kelola Pesanan</h1>
    <nav class="flex gap-1 rounded-xl bg-white p-1 shadow-card ring-1 ring-slate-200/70" data-testid="admin-nav">
        <a href="/admin" class="rounded-lg px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Ringkasan</a>
        <a href="/admin/products" class="rounded-lg px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Produk</a>
        <a href="/admin/orders" class="rounded-lg bg-ink-900 px-4 py-2 text-sm font-semibold text-white">Pesanan</a>
    </nav>
</div>

<?php if (!$orders): ?>
    <div class="mt-6 rounded-2xl border border-dashed border-slate-300 bg-white p-10 text-center" data-testid="empty-orders">
        <p class="font-semibold text-slate-700">Belum ada pesanan</p>
    </div>
<?php else: ?>
<div class="mt-6 overflow-hidden rounded-2xl bg-white shadow-card ring-1 ring-slate-200/70">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100 text-sm" data-testid="orders-table">
            <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-6 py-3.5">Pesanan #</th>
                    <th class="px-6 py-3.5">Pelanggan</th>
                    <th class="px-6 py-3.5">Barang</th>
                    <th class="px-6 py-3.5">Tanggal</th>
                    <th class="px-6 py-3.5">Total</th>
                    <th class="px-6 py-3.5">Status</th>
                    <th class="px-6 py-3.5 text-right">Tindakan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php foreach ($orders as $o): ?>
                <tr class="hover:bg-slate-50/60" data-testid="order-admin-row-<?= $o['id'] ?>">
                    <td class="px-6 py-4 font-mono text-xs font-semibold text-ink-900"><?= e($o['order_number']) ?></td>
                    <td class="px-6 py-4">
                        <p class="font-semibold text-ink-900"><?= e($o['user_name']) ?></p>
                        <p class="text-xs text-slate-400"><?= e($o['user_email']) ?></p>
                    </td>
                    <td class="px-6 py-4 max-w-xs text-slate-600"><?= implode(', ', array_map(fn($i) => e($i['title']), $o['items'])) ?></td>
                    <td class="px-6 py-4 text-slate-500"><?= date('d M Y', strtotime($o['created_at'])) ?></td>
                    <td class="px-6 py-4 font-semibold text-ink-900"><?= money($o['total_amount']) ?></td>
                    <td class="px-6 py-4"><?= status_badge($o['payment_status']) ?></td>
                    <td class="px-6 py-4 text-right">
                        <?php if ($o['payment_status'] === 'pending'): ?>
                        <form method="POST" action="/admin/orders/pay">
                            <input type="hidden" name="id" value="<?= $o['id'] ?>">
                            <button type="submit" class="rounded-lg bg-emerald-600 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-emerald-500" data-testid="mark-paid-<?= $o['id'] ?>">Tandai Dibayar</button>
                        </form>
                        <?php else: ?>
                            <span class="text-xs font-medium text-slate-400">—</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>
