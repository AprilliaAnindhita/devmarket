<div class="mx-auto grid min-h-[70vh] max-w-md place-items-center">
    <div class="w-full fade-up">
        <div class="rounded-3xl bg-white p-8 shadow-card ring-1 ring-slate-200/70">
            <h1 class="font-display text-2xl font-bold text-ink-900">Buat akun Anda</h1>
            <p class="mt-1 text-sm text-slate-500">Bergabunglah dengan DevMarket untuk membeli dan mengunduh aset premium.</p>

            <form method="POST" action="/register" class="mt-6 space-y-4" data-testid="register-form">
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Nama lengkap</label>
                    <input type="text" name="name" value="<?= e(old('name')) ?>" required class="w-full rounded-xl border-0 bg-slate-50 px-4 py-3 text-sm text-slate-800 ring-1 ring-inset ring-slate-200 focus:bg-white focus:ring-2 focus:ring-brand-500" data-testid="register-name" placeholder="Budi Santoso">
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Email</label>
                    <input type="email" name="email" value="<?= e(old('email')) ?>" required class="w-full rounded-xl border-0 bg-slate-50 px-4 py-3 text-sm text-slate-800 ring-1 ring-inset ring-slate-200 focus:bg-white focus:ring-2 focus:ring-brand-500" data-testid="register-email" placeholder="anda@contoh.com">
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Kata Sandi</label>
                    <input type="password" name="password" required minlength="6" class="w-full rounded-xl border-0 bg-slate-50 px-4 py-3 text-sm text-slate-800 ring-1 ring-inset ring-slate-200 focus:bg-white focus:ring-2 focus:ring-brand-500" data-testid="register-password" placeholder="Minimal 6 karakter">
                </div>
                <button type="submit" class="w-full rounded-xl bg-brand-600 px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-brand-600/30 transition hover:bg-brand-500" data-testid="register-submit">Buat akun</button>
            </form>

            <p class="mt-5 text-center text-sm text-slate-500">
                Sudah punya akun? <a href="/login" class="font-semibold text-brand-600 hover:text-brand-700" data-testid="go-login">Masuk</a>
            </p>
        </div>
    </div>
</div>
