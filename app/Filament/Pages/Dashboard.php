<?php

namespace App\Filament\Pages;

// Import semua widget yang INGIN DITAMPILKAN
use App\Filament\Widgets\DocumentsChart;
use App\Filament\Widgets\RecentDocuments;
use App\Filament\Widgets\StatsOverview;
use Filament\Widgets\AccountWidget; // Widget "Welcome" bawaan

use Filament\Pages\Dashboard as BasePage;

class Dashboard extends BasePage
{
    /**
     * Metode ini mendefinisikan widget apa saja yang tampil di dasbor
     * dan dalam urutan apa.
     */
    public function getWidgets(): array
    {
        return [
            // BARIS PERTAMA: Welcome Card, lebar penuh secara otomatis
            AccountWidget::class,

            // BARIS KEDUA: Stats Overview, lebar penuh,
            // isinya (2 kartu) akan membagi ruang.
            StatsOverview::class,

            // BARIS KETIGA: Chart, akan mengambil lebar penuh
            DocumentsChart::class,

            // BARIS KEEMPAT: Riwayat Terbaru, juga lebar penuh
            RecentDocuments::class,
        ];
    }

    /**
     * Mengatur layout menjadi 1 kolom saja (bertumpuk).
     */
    public function getColumns(): int
    {
        return 1;
    }

    // Kita hapus getHeaderWidgets() agar semua diatur di getWidgets()
    // untuk konsistensi.
}
