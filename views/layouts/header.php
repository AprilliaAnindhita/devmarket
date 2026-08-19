<?php $u = Auth::user(); ?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'DevMarket') ?> · DevMarket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        display: ['Sora', 'sans-serif'],
                    },
                    colors: {
                        ink: {
                            900: '#0b1020', 800: '#141b33', 700: '#1e2746',
                        },
                        brand: {
                            50:'#eef2ff',100:'#e0e7ff',400:'#818cf8',500:'#6366f1',600:'#4f46e5',700:'#4338ca',
                        },
                    },
                    boxShadow: {
                        card: '0 1px 2px rgba(16,24,40,.06), 0 12px 32px -12px rgba(16,24,40,.18)',
                    },
                },
            },
        };
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        h1,h2,h3,.font-display { font-family: 'Sora', sans-serif; }
        ::selection { background: #4f46e5; color:#fff; }
        .fade-up { animation: fadeUp .5s cubic-bezier(.16,.84,.44,1) both; }
        @keyframes fadeUp { from { opacity:0; transform: translateY(12px);} to {opacity:1; transform:none;} }
    </style>
</head>
<body class="flex min-h-screen flex-col bg-slate-100 text-slate-800 antialiased">

<header class="sticky top-0 z-40 bg-ink-900 text-slate-100 shadow-lg shadow-ink-900/20">
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-3.5 sm:px-6">
        <a href="/" class="flex items-center gap-2.5 group" data-testid="brand-logo">
            <span class="grid h-9 w-9 place-items-center rounded-xl bg-brand-600 font-display text-lg font-bold text-white shadow-lg shadow-brand-600/30 transition group-hover:scale-105">D</span>
            <span class="font-display text-xl font-bold tracking-tight">Dev<span class="text-brand-400">Market</span></span>
        </a>

        <nav class="hidden items-center gap-1 md:flex" data-testid="desktop-nav">
            <a href="/" class="rounded-lg px-3.5 py-2 text-sm font-medium text-slate-300 transition hover:bg-ink-700 hover:text-white">Toko</a>
            <?php if ($u && $u['role'] === 'buyer'): ?>
                <a href="/dashboard" class="rounded-lg px-3.5 py-2 text-sm font-medium text-slate-300 transition hover:bg-ink-700 hover:text-white" data-testid="nav-dashboard">Dashboard</a>
            <?php endif; ?>
            <?php if ($u && $u['role'] === 'admin'): ?>
                <a href="/admin" class="rounded-lg px-3.5 py-2 text-sm font-medium text-slate-300 transition hover:bg-ink-700 hover:text-white" data-testid="nav-admin">Admin</a>
            <?php endif; ?>
        </nav>

        <div class="flex items-center gap-2">
            <a href="/cart" class="relative rounded-lg p-2.5 text-slate-300 transition hover:bg-ink-700 hover:text-white" data-testid="nav-cart" aria-label="Cart">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/></svg>
                <?php if (cart_count() > 0): ?>
                    <span class="absolute -right-0.5 -top-0.5 grid h-5 min-w-5 place-items-center rounded-full bg-brand-500 px-1 text-[11px] font-bold text-white" data-testid="cart-count"><?= cart_count() ?></span>
                <?php endif; ?>
            </a>

            <?php if ($u): ?>
                <div class="hidden items-center gap-2 sm:flex">
                    <span class="text-sm text-slate-300">Hai, <span class="font-semibold text-white"><?= e(explode(' ', $u['name'])[0]) ?></span></span>
                    <a href="/logout" class="rounded-lg bg-ink-700 px-3.5 py-2 text-sm font-semibold text-white transition hover:bg-ink-800" data-testid="nav-logout">Keluar</a>
                </div>
            <?php else: ?>
                <a href="/login" class="hidden rounded-lg px-3.5 py-2 text-sm font-semibold text-slate-200 transition hover:text-white sm:block" data-testid="nav-login">Masuk</a>
                <a href="/register" class="rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-brand-600/30 transition hover:bg-brand-500" data-testid="nav-register">Daftar</a>
            <?php endif; ?>

            <button id="mobile-toggle" class="rounded-lg p-2.5 text-slate-300 transition hover:bg-ink-700 md:hidden" data-testid="mobile-menu-toggle" aria-label="Menu">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
            </button>
        </div>
    </div>

    <div id="mobile-menu" class="hidden border-t border-ink-700 bg-ink-800 md:hidden" data-testid="mobile-nav">
        <div class="space-y-1 px-4 py-3">
            <a href="/" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-slate-200 hover:bg-ink-700">Toko</a>
            <?php if ($u && $u['role'] === 'buyer'): ?><a href="/dashboard" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-slate-200 hover:bg-ink-700">Dashboard</a><?php endif; ?>
            <?php if ($u && $u['role'] === 'admin'): ?><a href="/admin" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-slate-200 hover:bg-ink-700">Admin</a><?php endif; ?>
            <a href="/cart" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-slate-200 hover:bg-ink-700">Keranjang (<?= cart_count() ?>)</a>
            <?php if ($u): ?>
                <a href="/logout" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-slate-200 hover:bg-ink-700">Keluar</a>
            <?php else: ?>
                <a href="/login" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-slate-200 hover:bg-ink-700">Masuk</a>
                <a href="/register" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-slate-200 hover:bg-ink-700">Daftar</a>
            <?php endif; ?>
        </div>
    </div>
</header>

<?php $flashes = get_flashes(); ?>
<?php if ($flashes): ?>
<div class="mx-auto max-w-7xl px-4 sm:px-6" data-testid="flash-container">
    <div class="space-y-2 pt-4">
        <?php foreach ($flashes as $f):
            $tone = $f['type'] === 'success'
                ? 'bg-emerald-50 text-emerald-800 ring-emerald-600/20'
                : ($f['type'] === 'error' ? 'bg-rose-50 text-rose-800 ring-rose-600/20' : 'bg-brand-50 text-brand-700 ring-brand-600/20');
        ?>
        <div class="fade-up flex items-start gap-3 rounded-xl px-4 py-3 text-sm font-medium ring-1 ring-inset <?= $tone ?>" data-testid="flash-<?= e($f['type']) ?>">
            <span class="mt-0.5 h-2 w-2 shrink-0 rounded-full bg-current"></span>
            <span><?= e($f['msg']) ?></span>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<main class="mx-auto w-full max-w-7xl flex-1 px-4 py-8 sm:px-6">
