<nav class="mb-6 flex items-center gap-2 text-sm text-slate-500" data-testid="breadcrumb">
    <a href="/" class="hover:text-brand-600">Shop</a>
    <span>/</span>
    <a href="/?category=<?= e($product['category_slug']) ?>" class="hover:text-brand-600"><?= e($product['category_name']) ?></a>
    <span>/</span>
    <span class="text-slate-700"><?= e($product['title']) ?></span>
</nav>

<div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
    <div class="fade-up overflow-hidden rounded-3xl bg-white shadow-card ring-1 ring-slate-200">
        <img src="<?= e(thumb_url($product['thumbnail'])) ?>" alt="<?= e($product['title']) ?>" class="aspect-[16/11] w-full object-cover" data-testid="product-image">
    </div>

    <div class="fade-up flex flex-col">
        <span class="inline-flex w-fit items-center gap-2 rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold text-brand-700 ring-1 ring-inset ring-brand-600/20"><?= e($product['category_name']) ?></span>
        <h1 class="mt-4 font-display text-3xl font-extrabold tracking-tight text-ink-900 sm:text-4xl" data-testid="product-title"><?= e($product['title']) ?></h1>
        <div class="mt-4 flex items-center gap-3">
            <span class="rounded-xl bg-ink-900 px-4 py-2 font-display text-2xl font-bold text-white" data-testid="product-price"><?= money($product['price']) ?></span>
            <span class="text-sm text-slate-500">One-time purchase · lifetime download</span>
        </div>
        <p class="mt-6 text-base leading-relaxed text-slate-600" data-testid="product-description"><?= e($product['description']) ?></p>

        <ul class="mt-6 space-y-2.5">
            <?php foreach (['Instant digital download', 'Free lifetime updates', 'Commercial license included'] as $feat): ?>
            <li class="flex items-center gap-3 text-sm text-slate-700">
                <span class="grid h-6 w-6 place-items-center rounded-full bg-emerald-100 text-emerald-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                </span>
                <?= e($feat) ?>
            </li>
            <?php endforeach; ?>
        </ul>

        <form method="POST" action="/cart/add" class="mt-8 flex flex-wrap gap-3">
            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
            <input type="hidden" name="redirect" value="/product/<?= e($product['slug']) ?>">
            <button type="submit" class="flex-1 rounded-xl bg-brand-600 px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-brand-600/30 transition hover:bg-brand-500" data-testid="add-to-cart-btn">Tambah ke keranjang</button>
            <a href="/cart" class="rounded-xl bg-slate-100 px-6 py-3.5 text-center text-sm font-semibold text-slate-700 ring-1 ring-inset ring-slate-200 transition hover:bg-slate-200">View cart</a>
        </form>
    </div>
</div>

<?php if ($related): ?>
<section class="mt-16">
    <h2 class="font-display text-2xl font-bold text-ink-900">You might also like</h2>
    <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3" data-testid="related-products">
        <?php foreach ($related as $p): ?>
            <a href="/product/<?= e($p['slug']) ?>" class="group flex overflow-hidden rounded-2xl bg-white shadow-card ring-1 ring-slate-200/70 transition hover:-translate-y-0.5 hover:shadow-lg">
                <img src="<?= e(thumb_url($p['thumbnail'])) ?>" alt="<?= e($p['title']) ?>" class="h-24 w-28 shrink-0 object-cover" loading="lazy">
                <div class="flex flex-col justify-center p-4">
                    <span class="font-display font-bold text-ink-900 transition group-hover:text-brand-600"><?= e($p['title']) ?></span>
                    <span class="mt-1 text-sm font-semibold text-brand-700"><?= money($p['price']) ?></span>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>
