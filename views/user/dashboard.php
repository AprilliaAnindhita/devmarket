<?php $me = Auth::user(); ?>
<div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="font-display text-3xl font-extrabold tracking-tight text-ink-900">Dashboard Saya</h1>
        <p class="mt-1 text-sm text-slate-500">Selamat datang kembali, <?= e($me['name']) ?></p>
    </div>
    <a href="/" class="w-fit rounded-xl bg-ink-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-ink-700">Jelajahi aset lainnya</a>
</div>

<!-- My Downloads -->
<section class="mt-8">
    <h2 class="font-display text-xl font-bold text-ink-900">Unduhan Saya</h2>
    <p class="mt-1 text-sm text-slate-500">Aset dari pesanan berbayar Anda. Klik untuk mengunduh file yang dilindungi.</p>

    <?php if (!$downloads): ?>
        <div class="mt-4 rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-center" data-testid="empty-downloads">
            <p class="font-semibold text-slate-700">Belum ada unduhan</p>
            <p class="mt-1 text-sm text-slate-500">Setelah pesanan ditandai dibayar, aset Anda muncul di sini.</p>
        </div>
    <?php else: ?>
        <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3" data-testid="downloads-grid">
            <?php foreach ($downloads as $p): ?>
            <div class="flex items-center gap-4 rounded-2xl bg-white p-4 shadow-card ring-1 ring-slate-200/70" data-testid="download-item-<?= $p['id'] ?>">
                <img src="<?= e(thumb_url($p['thumbnail'])) ?>" alt="<?= e($p['title']) ?>" class="h-16 w-16 shrink-0 rounded-xl object-cover">
                <div class="min-w-0 flex-1">
                    <p class="truncate font-semibold text-ink-900"><?= e($p['title']) ?></p>
                    <a href="/download/<?= $p['id'] ?>" class="mt-1.5 inline-flex items-center gap-1.5 rounded-lg bg-emerald-600 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-emerald-500" data-testid="download-btn-<?= $p['id'] ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                        Unduh Aset
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<!-- Order history -->
<section class="mt-10">
    <h2 class="font-display text-xl font-bold text-ink-900">Riwayat Pesanan</h2>
    <?php if (!$orders): ?>
        <div class="mt-4 rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-center" data-testid="empty-orders">
            <p class="font-semibold text-slate-700">Belum ada pesanan</p>
            <a href="/" class="mt-3 inline-block text-sm font-semibold text-brand-600 hover:text-brand-700">Mulai berbelanja →</a>
        </div>
    <?php else: ?>
        <div class="mt-4 overflow-hidden rounded-2xl bg-white shadow-card ring-1 ring-slate-200/70">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 text-sm" data-testid="orders-table">
                    <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-5 py-3.5">Pesanan #</th>
                            <th class="px-5 py-3.5">Barang</th>
                            <th class="px-5 py-3.5">Tanggal</th>
                            <th class="px-5 py-3.5">Total</th>
                            <th class="px-5 py-3.5">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php foreach ($orders as $o): ?>
                        <tr class="hover:bg-slate-50/60" data-testid="order-row-<?= $o['id'] ?>">
                            <td class="px-5 py-4 font-mono text-xs font-semibold text-ink-900"><?= e($o['order_number']) ?></td>
                            <td class="px-5 py-4 text-slate-600">
                                <?= implode(', ', array_map(fn($i) => e($i['title']), $o['items'])) ?>
                            </td>
                            <td class="px-5 py-4 text-slate-500"><?= date('d M Y', strtotime($o['created_at'])) ?></td>
                            <td class="px-5 py-4 font-semibold text-ink-900"><?= money($o['total_amount']) ?></td>
                            <td class="px-5 py-4"><?= status_badge($o['payment_status']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</section>
