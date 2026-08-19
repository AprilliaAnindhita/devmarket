<div class="mx-auto grid min-h-[70vh] max-w-md place-items-center">
    <div class="w-full fade-up">
        <div class="rounded-3xl bg-white p-8 shadow-card ring-1 ring-slate-200/70">
            <h1 class="font-display text-2xl font-bold text-ink-900">Selamat kembali</h1>
            <p class="mt-1 text-sm text-slate-500">Masuk untuk mengakses unduhan dan pesanan Anda.</p>

            <form method="POST" action="/login" class="mt-6 space-y-4" data-testid="login-form">
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Email</label>
                    <input type="email" name="email" value="<?= e(old('email')) ?>" required class="w-full rounded-xl border-0 bg-slate-50 px-4 py-3 text-sm text-slate-800 ring-1 ring-inset ring-slate-200 focus:bg-white focus:ring-2 focus:ring-brand-500" data-testid="login-email" placeholder="anda@contoh.com">
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Kata Sandi</label>
                    <input type="password" name="password" required class="w-full rounded-xl border-0 bg-slate-50 px-4 py-3 text-sm text-slate-800 ring-1 ring-inset ring-slate-200 focus:bg-white focus:ring-2 focus:ring-brand-500" data-testid="login-password" placeholder="••••••••">
                </div>
                <button type="submit" class="w-full rounded-xl bg-brand-600 px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-brand-600/30 transition hover:bg-brand-500" data-testid="login-submit">Masuk</button>
            </form>

            <p class="mt-5 text-center text-sm text-slate-500">
                Tidak punya akun? <a href="/register" class="font-semibold text-brand-600 hover:text-brand-700" data-testid="go-register">Buat satu</a>
            </p>
        </div>

        <div class="mt-4 rounded-2xl bg-ink-900 p-4 text-xs text-slate-300" data-testid="demo-credentials">
            <p class="font-semibold text-white">Akun demo</p>
            <p class="mt-1.5">Admin — <span class="text-brand-400">admin@devmarket.com</span> / admin123</p>
            <p>Pembeli — <span class="text-brand-400">buyer@devmarket.com</span> / buyer123</p>
        </div>
    </div>
</div>
