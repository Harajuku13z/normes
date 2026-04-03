<script>
(function () {
    var els = document.querySelectorAll('[data-countup]');
    if (!els.length) return;
    var reduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    function animate(el) {
        if (el.dataset.countupDone) return;
        el.dataset.countupDone = '1';
        var raw = el.dataset.countup;
        var pad = parseInt(el.dataset.countupPad || '0', 10);
        var match = raw.match(/^([^\d]*)([\d\s.,]+)([^\d]*)$/);
        if (!match) { el.textContent = raw; return; }
        var prefix = match[1];
        var numStr = match[2].replace(/\s/g, '');
        var suffix = match[3];
        var hasDecimal = numStr.indexOf(',') !== -1 || numStr.indexOf('.') !== -1;
        var sep = numStr.indexOf(',') !== -1 ? ',' : '.';
        var target = parseFloat(numStr.replace(',', '.'));
        if (isNaN(target)) { el.textContent = raw; return; }
        var decimals = hasDecimal ? (numStr.split(sep)[1] || '').length : 0;
        var useSpacer = /\d{4}/.test(numStr.replace(/[.,]/g, '')) || numStr.indexOf(' ') !== -1;

        if (reduced) { el.textContent = raw; return; }

        var duration = Math.min(2000, Math.max(800, target * 15));
        var start = performance.now();

        function step(now) {
            var t = Math.min((now - start) / duration, 1);
            var ease = 1 - Math.pow(1 - t, 3);
            var val = ease * target;
            var display = hasDecimal ? val.toFixed(decimals).replace('.', sep) : Math.round(val).toString();
            if (useSpacer && !hasDecimal) {
                display = display.replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
            }
            if (pad > 0 && !hasDecimal) {
                while (display.length < pad) display = '0' + display;
            }
            el.textContent = prefix + display + suffix;
            if (t < 1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
    }

    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting) { animate(e.target); io.unobserve(e.target); }
            });
        }, { threshold: 0.3 });
        els.forEach(function (el) { io.observe(el); });
    } else {
        els.forEach(animate);
    }
})();
</script>
