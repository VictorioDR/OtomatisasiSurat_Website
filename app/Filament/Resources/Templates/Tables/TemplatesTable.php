<?php

namespace App\Filament\Resources\Templates\Tables;

use App\Models\Template;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TemplatesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->searchable(),
                TextColumn::make('name')->searchable(),
                TextColumn::make('file_path')->searchable(),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('generate')
                    ->label('Generate')
                    ->icon('heroicon-o-document-arrow-down')
                    ->url(fn (Template $record): string => route('generate.show', $record))
                    ->openUrlInNewTab(),
                EditAction::make(), // ✅ hanya ada Edit, tanpa Detail
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
