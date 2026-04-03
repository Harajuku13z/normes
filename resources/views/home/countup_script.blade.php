<script>
(function () {
    function run() {
        var els = document.querySelectorAll('[data-countup]');
        if (!els.length) return;

        function parseValue(el) {
            var raw = (el.getAttribute('data-countup') || '').trim();
            if (!raw) return null;

            var prefix, suffix, numStr;

            if (el.hasAttribute('data-countup-prefix')) {
                prefix = el.getAttribute('data-countup-prefix') || '';
                suffix = el.getAttribute('data-countup-suffix') || '';
                numStr = raw.replace(/\s/g, '');
            } else {
                var m = raw.match(/^([^\d]*)([\d\s.,]+)([^\d]*)$/);
                if (!m) return null;
                prefix = m[1];
                numStr = m[2].replace(/\s/g, '');
                suffix = m[3];
            }

            var hasDec = numStr.indexOf(',') > -1 || numStr.indexOf('.') > -1;
            var sep = numStr.indexOf(',') > -1 ? ',' : '.';
            var target = parseFloat(numStr.replace(',', '.'));
            if (isNaN(target)) return null;

            var decimals = hasDec ? (numStr.split(sep)[1] || '').length : 0;
            var useSpacer = numStr.replace(/[.,]/g, '').length >= 4;
            var pad = parseInt(el.getAttribute('data-countup-pad') || '0', 10);

            return { prefix: prefix, suffix: suffix, target: target, hasDec: hasDec, sep: sep, decimals: decimals, useSpacer: useSpacer, pad: pad, raw: raw };
        }

        function format(val, p) {
            var s = p.hasDec ? val.toFixed(p.decimals).replace('.', p.sep) : Math.round(val).toString();
            if (p.useSpacer && !p.hasDec) s = s.replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
            if (p.pad > 0 && !p.hasDec) { while (s.length < p.pad) s = '0' + s; }
            return s;
        }

        function animate(el) {
            var p = parseValue(el);
            if (!p || p.target === 0) {
                el.textContent = p ? p.prefix + p.raw + p.suffix : el.getAttribute('data-countup');
                return;
            }

            el.textContent = p.prefix + '0' + p.suffix;

            var duration = Math.min(2200, Math.max(800, p.target * 10));
            var start = -1;

            function step(ts) {
                if (start < 0) start = ts;
                var t = Math.min((ts - start) / duration, 1);
                var ease = 1 - Math.pow(1 - t, 3);
                el.textContent = p.prefix + format(ease * p.target, p) + p.suffix;
                if (t < 1) requestAnimationFrame(step);
            }

            requestAnimationFrame(step);
        }

        function isVisible(el) {
            var r = el.getBoundingClientRect();
            return r.top < window.innerHeight + 50 && r.bottom > -50;
        }

        function check() {
            for (var i = 0; i < els.length; i++) {
                if (!els[i]._cuDone && isVisible(els[i])) {
                    els[i]._cuDone = true;
                    animate(els[i]);
                }
            }
        }

        window.addEventListener('scroll', check, { passive: true });
        window.addEventListener('resize', check, { passive: true });
        check();
        setTimeout(check, 300);
        setTimeout(check, 1000);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', run);
    } else {
        run();
    }
})();
</script>
