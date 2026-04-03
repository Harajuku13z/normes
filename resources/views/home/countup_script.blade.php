<script>
(function () {
    var els = document.querySelectorAll('[data-countup]');
    if (!els.length) return;
    var reduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    function parse(raw) {
        var match = raw.match(/^([^\d]*)([\d\s.,]+)([^\d]*)$/);
        if (!match) return null;
        var prefix = match[1];
        var numStr = match[2].replace(/\s/g, '');
        var suffix = match[3];
        var hasDecimal = numStr.indexOf(',') !== -1 || numStr.indexOf('.') !== -1;
        var sep = numStr.indexOf(',') !== -1 ? ',' : '.';
        var target = parseFloat(numStr.replace(',', '.'));
        if (isNaN(target)) return null;
        var decimals = hasDecimal ? (numStr.split(sep)[1] || '').length : 0;
        var useSpacer = /\d{4}/.test(numStr.replace(/[.,]/g, '')) || numStr.indexOf(' ') !== -1;
        return { prefix: prefix, suffix: suffix, target: target, hasDecimal: hasDecimal, sep: sep, decimals: decimals, useSpacer: useSpacer };
    }

    function formatNum(val, p) {
        var display = p.hasDecimal ? val.toFixed(p.decimals).replace('.', p.sep) : Math.round(val).toString();
        if (p.useSpacer && !p.hasDecimal) {
            display = display.replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
        }
        return display;
    }

    function animate(el) {
        if (el.dataset.countupDone) return;
        el.dataset.countupDone = '1';
        var raw = el.dataset.countup;
        var pad = parseInt(el.dataset.countupPad || '0', 10);
        var p = parse(raw);
        if (!p) { el.textContent = raw; return; }

        if (reduced) { el.textContent = raw; return; }

        var zero = formatNum(0, p);
        if (pad > 0 && !p.hasDecimal) { while (zero.length < pad) zero = '0' + zero; }
        el.textContent = p.prefix + zero + p.suffix;

        var duration = Math.min(2200, Math.max(900, p.target * 12));
        var start = performance.now();

        function step(now) {
            var t = Math.min((now - start) / duration, 1);
            var ease = 1 - Math.pow(1 - t, 3);
            var val = ease * p.target;
            var display = formatNum(val, p);
            if (pad > 0 && !p.hasDecimal) { while (display.length < pad) display = '0' + display; }
            el.textContent = p.prefix + display + p.suffix;
            if (t < 1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
    }

    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting) { animate(e.target); io.unobserve(e.target); }
            });
        }, { threshold: 0.05, rootMargin: '0px 0px 100px 0px' });
        els.forEach(function (el) { io.observe(el); });
    } else {
        els.forEach(animate);
    }
})();
</script>
