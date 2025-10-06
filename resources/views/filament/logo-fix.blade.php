<!-- ============================================= -->
<!-- PERBAIKAN LOGO (CSS) -->
<!-- ============================================= -->
<style>
    /* ------------------------------------------- */
    /* ATURAN UMUM */
    /* ------------------------------------------- */
    /* Hapus filter abu-abu dari semua logo */
    .fi-logo {
        filter: none !important;
    }

    /* ------------------------------------------- */
    /* LOGIKA UNTUK SIDEBAR LEBAR (EXPANDED) */
    /* ------------------------------------------- */
    /* Default (Mode Terang): gunakan logo teks oranye */
    :not(.fi-sidebar-is-collapsed) .fi-logo {
        content: url('{{ asset('images/logo.png') }}');
    }

    /* JIKA Mode Gelap: ganti ke logo teks kuning */
    html.dark :not(.fi-sidebar-is-collapsed) .fi-logo {
        content: url('{{ asset('images/logo-dark.png') }}');
    }

    /* ------------------------------------------- */
    /* LOGIKA UNTUK SIDEBAR DICUITKAN (COLLAPSED) */
    /* ------------------------------------------- */
    /* Atur "wadah" ikon petir agar menjadi BULAT dan RAPI */
    .fi-sidebar-is-collapsed .fi-topbar .fi-logo-ctn {
        background-color: transparent !important;
        border-radius: 9999px !important;
        padding: 0.375rem !important;
        width: 3rem; /* UKURAN WADAH LINGKARAN */
        height: 3rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-inline-start: 0.5rem;
    }

    /* Atur ikon di dalam lingkaran agar ukurannya pas */
    .fi-sidebar-is-collapsed .fi-logo {
        content: url('{{ asset('images/favicon.png') }}');
        width: 2rem; /* UKURAN IKON, harus lebih kecil dari wadah */
        height: 2rem;
    }

    /* JIKA Mode Gelap: ganti ke favicon kuning */
    html.dark .fi-sidebar-is-collapsed .fi-logo {
        content: url('{{ asset('images/favicon-dark.png') }}');
    }
</style>

<!-- ============================================= -->
<!-- PERBAIKAN BUG CHART RESIZE (JAVASCRIPT) -->
<!-- ============================================= -->
<script>
    // Pastikan skrip ini tidak dijalankan berulang kali
    if (!window.chartResizeListenerAttached) {
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        const handleResize = () => {
            window.dispatchEvent(new Event('chart:update'));
        };

        window.addEventListener('resize', debounce(handleResize, 200));

        // Tandai bahwa listener sudah dipasang
        window.chartResizeListenerAttached = true;
    }
</script>
