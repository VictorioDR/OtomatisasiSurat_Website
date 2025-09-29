<?php

namespace App\Filament\Widgets;

use App\Models\GeneratedDocument;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class DocumentsChart extends ChartWidget
{
    protected ?string $heading = 'Dokumen Dihasilkan (6 Bulan Terakhir)';
    protected static ?int $sort = 2; // Urutan widget

    protected function getData(): array
    {
        $data = GeneratedDocument::query()
            ->where('created_at', '>=', now()->subMonths(6))
            ->where('user_id', auth()->id()) // Data per user
            ->orderBy('created_at')
            ->get()
            ->groupBy(function($item) {
                return Carbon::parse($item->created_at)->format('F Y'); // Grup per Bulan Tahun
            })
            ->map(function($group) {
                return count($group);
            });

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Dokumen',
                    'data' => $data->values()->toArray(),
                    'backgroundColor' => '#f59e0b',
                    'borderColor' => '#d97706',
                ],
            ],
            'labels' => $data->keys()->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // Tipe chart: bar, line, pie, etc.
    }
}
