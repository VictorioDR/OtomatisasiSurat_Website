<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\GeneratedDocuments\GeneratedDocumentResource;
use App\Models\GeneratedDocument;
use Filament\Actions\Action;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentDocuments extends BaseWidget
{

    protected static bool $isLazy = true;

    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
            // Mengambil 5 dokumen terakhir milik user
                GeneratedDocument::query()
                    ->with('template')
                    ->where('user_id', auth()->id())
                    ->latest()
                    ->limit(5)
            )
            ->heading('Riwayat Dokumen Terbaru')
            ->columns([
                Tables\Columns\TextColumn::make('template.name')->label('Template'),
                Tables\Columns\TextColumn::make('created_at')->label('Dibuat Pada')->since(),
            ])
            ->actions([
                Action::make('Lihat Semua')
                    ->url(GeneratedDocumentResource::getUrl('index'))
            ]);
    }
}
