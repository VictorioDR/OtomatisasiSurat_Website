<script>
    document.addEventListener('DOMContentLoaded', function () {
        try {
            const shouldGo = (location.hash === '#formFields') || (new URLSearchParams(location.search).get('tab') === 'formFields');
            if (!shouldGo) return;

            // tunda sedikit supaya Filament sudah merender relation managers
            setTimeout(() => {
                // cari elemen yang kelihatan seperti judul relation manager "Detail" / "Form Fields"
                let el = document.querySelector('#formFields');
                if (!el) {
                    el = Array.from(document.querySelectorAll('h2, h3')).find(h => /Detail|Field|Form Fields/i.test(h.textContent));
                    if (el) el = el.closest('.filament-resources-page') || el;
                }
                if (!el) {
                    // coba cari element dengan teks Relationship atau label
                    el = Array.from(document.querySelectorAll('div')).find(d => /formfields|form-fields|form fields|detail/i.test(d.getAttribute('id') || d.className || d.innerText));
                }
                if (el) {
                    el.scrollIntoView({behavior:'smooth', block:'center'});
                    el.style.transition = 'box-shadow 0.3s ease';
                    el.style.boxShadow = '0 0 0 4px rgba(250,204,21,0.24)';
                    setTimeout(()=> el.style.boxShadow = '', 2000);
                }
            }, 500);
        } catch (e) {
            console.error('scroll-to-relation error', e);
        }
    });
</script>
