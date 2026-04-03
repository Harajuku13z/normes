<script>
(function () {
    function init() {
        var els = document.querySelectorAll('[data-countup]');
        if (!els.length) return;
        var reduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        function parseOld(raw) {
            var m = raw.match(/^([^\d]*)([\d\s.,]+)([^\d]*)$/);
            if (!m) return null;
            return { prefix: m[1], numStr: m[2].replace(/\s/g, ''), suffix: m[3] };
        }

        function animate(el) {
            if (el.dataset.countupDone) return;
            el.dataset.countupDone = '1';

            var raw = (el.dataset.countup || '').trim();
            var hasAttrs = el.hasAttribute('data-countup-prefix');
            var prefix, suffix, numStr;

            if (hasAttrs) {
                prefix = el.dataset.countupPrefix || '';
                suffix = el.dataset.countupSuffix || '';
                numStr = raw.replace(/\s/g, '');
            } else {
                var parsed = parseOld(raw);
                if (!parsed) { el.textContent = raw; return; }
                prefix = parsed.prefix;
                suffix = parsed.suffix;
                numStr = parsed.numStr;
            }

            var hasDecimal = numStr.indexOf(',') !== -1 || numStr.indexOf('.') !== -1;
            var sep = numStr.indexOf(',') !== -1 ? ',' : '.';
            var target = parseFloat(numStr.replace(',', '.'));

            if (isNaN(target) || target === 0) {
                el.textContent = prefix + raw + suffix;
                return;
            }

            var decimals = hasDecimal ? (numStr.split(sep)[1] || '').length : 0;
            var useSpacer = numStr.replace(/[.,]/g, '').length >= 4;
            var pad = parseInt(el.dataset.countupPad || '0', 10);

            if (reduced) { el.textContent = prefix + numStr + suffix; return; }

            el.textContent = prefix + '0' + suffix;

            var duration = Math.min(2200, Math.max(900, target * 12));
            var start = performance.now();

            function format(val) {
                var s = hasDecimal ? val.toFixed(decimals).replace('.', sep) : Math.round(val).toString();
                if (useSpacer && !hasDecimal) s = s.replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
                if (pad > 0 && !hasDecimal) { while (s.length < pad) s = '0' + s; }
                return s;
            }

            function step(now) {
                var t = Math.min((now - start) / duration, 1);
                var ease = 1 - Math.pow(1 - t, 3);
                el.textContent = prefix + format(ease * target) + suffix;
                if (t < 1) requestAnimationFrame(step);
            }
            requestAnimationFrame(step);
        }

        function isInView(el) {
            var r = el.getBoundingClientRect();
            return r.top < window.innerHeight + 150 && r.bottom > -150;
        }

        function checkAll() {
            els.forEach(function (el) {
                if (!el.dataset.countupDone && isInView(el)) animate(el);
            });
        }

        if ('IntersectionObserver' in window) {
            var io = new IntersectionObserver(function (entries) {
                entries.forEach(function (e) {
                    if (e.isIntersecting) { animate(e.target); io.unobserve(e.target); }
                });
            }, { threshold: 0, rootMargin: '0px 0px 150px 0px' });
            els.forEach(function (el) { io.observe(el); });
        }

        checkAll();

        var scrollTimer;
        window.addEventListener('scroll', function () {
            clearTimeout(scrollTimer);
            scrollTimer = setTimeout(checkAll, 80);
        }, { passive: true });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
</script>
