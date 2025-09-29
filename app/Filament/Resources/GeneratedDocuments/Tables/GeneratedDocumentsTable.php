<?php

namespace App\Filament\Resources\GeneratedDocuments\Tables;

use App\Models\GeneratedDocument;
use Filament\Actions\Action;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;

class GeneratedDocumentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('template.name')
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('Dibuat oleh')
                    ->sortable(),

                TextColumn::make('filled_data')
                    ->label('Data Terisi')
                    ->formatStateUsing(fn ($state) => json_encode($state, JSON_PRETTY_PRINT)) // tampilkan JSON rapi
                    ->limit(50) // biar nggak kepanjangan
                    ->tooltip(fn ($state) => json_encode($state, JSON_PRETTY_PRINT)),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                // filter template
                SelectFilter::make('template_id')
                    ->relationship('template', 'name')
                    ->label('Template'),
                // filter user
                SelectFilter::make('user_id')
                    ->relationship('user', 'name')
                    ->label('User'),
                // filter berdasarkan tanggal dibuat
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
                Action::make('download')
                    ->label('Download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (GeneratedDocument $record): string => Storage::disk('public')->url($record->file_path))
                    ->openUrlInNewTab(),
            ]);
    }
}
