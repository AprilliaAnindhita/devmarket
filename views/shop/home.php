<!-- Hero -->
<section class="fade-up overflow-hidden rounded-3xl bg-ink-900 px-6 py-12 text-white sm:px-12 sm:py-16">
    <div class="max-w-2xl">
        <h1 class="mt-5 font-display text-4xl font-extrabold leading-tight tracking-tight sm:text-5xl lg:text-6xl">
            Accelerate Your Digital Projects with <span class="text-brand-400">Premium Assets</span>
        </h1>
        <p class="mt-4 text-base text-slate-300 sm:text-lg">
            A curated collection of high-quality UI kits, templates, <em>source code</em>, and e-books for developers. Buy once, download, and use forever.
        </p>
        <div class="mt-7 flex flex-wrap gap-3">
            <a href="#catalog" class="rounded-xl bg-brand-600 px-5 py-3 text-sm font-semibold shadow-lg shadow-brand-600/30 transition hover:bg-brand-500" data-testid="hero-browse-btn">Explore digital assets</a>
            <?php if (Auth::check() && Auth::user()['role'] === 'buyer'): ?>
                <a href="/dashboard" class="rounded-xl bg-white/10 px-5 py-3 text-sm font-semibold ring-1 ring-inset ring-white/20 transition hover:bg-white/20">Dashboard saya</a>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Filters -->
<section id="catalog" class="mt-10 scroll-mt-24">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h2 class="font-display text-2xl font-bold text-ink-900">Explore digital assets</h2>
            <p class="mt-1 text-sm text-slate-500"><?= count($products) ?> produk<?= count($products) === 1 ? '' : 's' ?> tersedia</p>
        </div>
        <form method="GET" action="/" class="flex flex-wrap items-center gap-2" data-testid="filter-form">
            <div class="relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.34-4.34M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/></svg>
                <input type="text" name="q" value="<?= e($search) ?>" placeholder="Cari aset..." class="w-full rounded-xl border-0 bg-white py-2.5 pl-9 pr-3 text-sm text-slate-800 shadow-card ring-1 ring-inset ring-slate-200 placeholder:text-slate-400 focus:ring-2 focus:ring-brand-500 sm:w-56" data-testid="search-input">
            </div>
            <select name="category" class="rounded-xl border-0 bg-white py-2.5 pl-3 pr-8 text-sm text-slate-800 shadow-card ring-1 ring-inset ring-slate-200 focus:ring-2 focus:ring-brand-500" data-testid="category-select" onchange="this.form.submit()">
                <option value="">Semua kategori</option>
                <?php foreach ($categories as $c): ?>
                    <option value="<?= e($c['slug']) ?>" <?= $activeCat === $c['slug'] ? 'selected' : '' ?>><?= e($c['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <select name="sort" class="rounded-xl border-0 bg-white py-2.5 pl-3 pr-8 text-sm text-slate-800 shadow-card ring-1 ring-inset ring-slate-200 focus:ring-2 focus:ring-brand-500" data-testid="sort-select" onchange="this.form.submit()">
                <option value="">Terbaru</option>
                <option value="price_asc" <?= $sort === 'price_asc' ? 'selected' : '' ?>>Harga: Terendah ke Tertinggi</option>
                <option value="price_desc" <?= $sort === 'price_desc' ? 'selected' : '' ?>>Harga: Tertinggi ke Terendah</option>
                <option value="title_asc" <?= $sort === 'title_asc' ? 'selected' : '' ?>>Nama: A–Z</option>
            </select>
            <button type="submit" class="rounded-xl bg-ink-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-ink-700" data-testid="search-btn">Terapkan</button>
        </form>
    </div>

    <?php if (!$products): ?>
        <div class="mt-10 grid place-items-center rounded-2xl border border-dashed border-slate-300 bg-white py-20 text-center" data-testid="empty-products">
            <p class="text-lg font-semibold text-slate-700">Tidak ada produk yang ditemukan</p>
            <p class="mt-1 text-sm text-slate-500">Coba pencarian atau kategori yang berbeda.</p>
            <a href="/" class="mt-4 text-sm font-semibold text-brand-600 hover:text-brand-700">Hapus filter →</a>
        </div>
    <?php else: ?>
        <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3" data-testid="product-grid">
            <?php foreach ($products as $p): ?>
                <article class="fade-up group flex flex-col overflow-hidden rounded-2xl bg-white shadow-card ring-1 ring-slate-200/70 transition hover:-translate-y-1 hover:shadow-xl" data-testid="product-card-<?= $p['id'] ?>">
                    <a href="/product/<?= e($p['slug']) ?>" class="relative block aspect-[16/10] overflow-hidden bg-slate-100">
                        <img src="<?= e(thumb_url($p['thumbnail'])) ?>" alt="<?= e($p['title']) ?>" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" loading="lazy">
                        <span class="absolute left-3 top-3 rounded-full bg-ink-900/85 px-2.5 py-1 text-[11px] font-semibold text-white backdrop-blur"><?= e($p['category_name']) ?></span>
                    </a>
                    <div class="flex flex-1 flex-col p-5">
                        <a href="/product/<?= e($p['slug']) ?>" class="font-display text-lg font-bold text-ink-900 transition hover:text-brand-600"><?= e($p['title']) ?></a>
                        <p class="mt-1.5 line-clamp-2 flex-1 text-sm text-slate-500"><?= e($p['description']) ?></p>
                        <div class="mt-4 flex items-center justify-between">
                            <span class="rounded-lg bg-brand-50 px-2.5 py-1 font-display text-lg font-bold text-brand-700"><?= money($p['price']) ?></span>
                            <form method="POST" action="/cart/add">
                                <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                                <input type="hidden" name="redirect" value="/">
                                <button type="submit" class="rounded-xl bg-ink-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-brand-600" data-testid="add-to-cart-<?= $p['id'] ?>">Add to cart</button>
                            </form>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
