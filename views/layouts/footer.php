</main>

<footer class="mt-16 border-t border-slate-200 bg-white">
    <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-4 px-4 py-8 sm:flex-row sm:px-6">
        <div class="flex items-center gap-2.5">
            <span class="grid h-8 w-8 place-items-center rounded-lg bg-ink-900 font-display text-sm font-bold text-white">D</span>
            <span class="font-display text-lg font-bold text-ink-900">Dev<span class="text-brand-600">Market</span></span>
        </div>
        <p class="text-sm text-slate-500">Premium digital assets for developers &amp; designers. © <?= date('Y') ?> DevMarket.</p>
    </div>
</footer>

<script>
    const toggle = document.getElementById('mobile-toggle');
    const menu = document.getElementById('mobile-menu');
    if (toggle && menu) toggle.addEventListener('click', () => menu.classList.toggle('hidden'));
    // Auto-dismiss flash messages
    setTimeout(() => {
        document.querySelectorAll('[data-testid^="flash-"]').forEach(el => {
            el.style.transition = 'opacity .4s, transform .4s';
            el.style.opacity = '0';
            el.style.transform = 'translateY(-6px)';
            setTimeout(() => el.remove(), 400);
        });
    }, 4500);
</script>
</body>
</html>
