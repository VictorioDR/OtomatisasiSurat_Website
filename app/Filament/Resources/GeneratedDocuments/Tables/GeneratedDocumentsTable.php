<?php

namespace App\Filament\Resources\GeneratedDocuments\Tables;

use App\Models\GeneratedDocument;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\ViewAction; // <- benar untuk Table view action
use Filament\Tables\Actions\Action;     // <- benar untuk Table generic action (download dll)
use Illuminate\Support\Facades\Storage;


class GeneratedDocumentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->defaultPaginationPageOption(20) // batasi default pagination
            ->paginated([20, 50, 100]) // opsi pagination
            ->columns([
                TextColumn::make('template.name')
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('Dibuat oleh')
                    ->sortable(),

                TextColumn::make('filled_data')
                    ->label('Preview Data')
                    ->formatStateUsing(fn ($state, $record) => collect($record->filled_data)
                            ->take(2)
                            ->map(fn($v, $k) => "$k: $v")
                            ->implode(', ') . ' ...')
                    ->limit(50)
                    ->tooltip('Klik Lihat untuk detail'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('template_id')
                    ->relationship('template', 'name')
                    ->label('Template'),

                SelectFilter::make('user_id')
                    ->relationship('user', 'name')
                    ->label('User'),

                \Filament\Tables\Filters\Filter::make('created_at')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('from'),
                        \Filament\Forms\Components\DatePicker::make('until'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn ($q, $date) => $q->whereDate('created_at', '>=', $date))
                            ->when($data['until'], fn ($q, $date) => $q->whereDate('created_at', '<=', $date));
                    }),
            ])
            ->actions([
                ViewAction::make() // <-- sekarang aman
                ->modalHeading('Detail Data Terisi')
                    ->modalContent(fn ($record) => view('filament.modals.view-filled-data', [
                        'data' => $record->filled_data,
                    ])),

                Action::make('download')
                    ->label('Download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (GeneratedDocument $record): string => Storage::disk('public')->url($record->file_path))
                    ->openUrlInNewTab(),
            ]);
    }
}
