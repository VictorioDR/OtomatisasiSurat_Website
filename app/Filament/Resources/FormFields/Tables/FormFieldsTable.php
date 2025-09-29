<?php

namespace App\Filament\Resources\FormFields\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FormFieldsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('order')
            ->columns([
                TextColumn::make('template.name')->label('Template')->sortable()->searchable(),
                TextColumn::make('label')->searchable(),
                TextColumn::make('field_name')->searchable(),
                TextColumn::make('field_type'),
                IconColumn::make('is_required')->boolean(),
                TextColumn::make('order')->sortable(),
            ])
            ->filters([
                // ✅ filter berdasarkan template
                \Filament\Tables\Filters\SelectFilter::make('template_id')
                    ->relationship('template', 'name')
                    ->label('Template'),
                // ✅ filter berdasarkan tipe field
                \Filament\Tables\Filters\SelectFilter::make('field_type')
                    ->options([
                        'text' => 'Text',
                        'date' => 'Date',
                        'number' => 'Number',
                        'select' => 'Select',
                    ]),
                // ✅ filter required / tidak
                \Filament\Tables\Filters\TernaryFilter::make('is_required')
                    ->label('Required'),
            ])
            ->actions([])
            ->bulkActions([]);
    }
}
