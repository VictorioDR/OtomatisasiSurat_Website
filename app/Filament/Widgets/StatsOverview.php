<?php

namespace App\Filament\Widgets;

use App\Models\GeneratedDocument;
use App\Models\Template;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected int|array|null $columns = 2;

    protected function getStats(): array
    {
        $userId = auth()->id();

        return [
            Stat::make(
                'Total Template',
                Template::query()->when($userId, fn ($q) => $q->where('user_id', $userId))->count()
            )
                ->description('Jumlah master template yang telah Anda buat')
                ->descriptionIcon('heroicon-m-document-duplicate')
                ->color('success'),

            Stat::make(
                'Dokumen Dihasilkan',
                GeneratedDocument::query()->when($userId, fn ($q) => $q->where('user_id', $userId))->count()
            )
                ->description('Total dokumen yang pernah dibuat')
                ->descriptionIcon('heroicon-m-document-check')
                ->color('info')
                ->icon('heroicon-o-document-text'),
        ];
    }
}
