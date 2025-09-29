<?php

namespace App\Filament\Resources\GeneratedDocuments;

use App\Filament\Resources\GeneratedDocuments\Pages\CreateGeneratedDocument;
use App\Filament\Resources\GeneratedDocuments\Pages\EditGeneratedDocument;
use App\Filament\Resources\GeneratedDocuments\Pages\ListGeneratedDocuments;
use App\Filament\Resources\GeneratedDocuments\Schemas\GeneratedDocumentForm;
use App\Filament\Resources\GeneratedDocuments\Tables\GeneratedDocumentsTable;
use App\Models\GeneratedDocument;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class GeneratedDocumentResource extends Resource
{
    protected static ?string $model = GeneratedDocument::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return GeneratedDocumentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GeneratedDocumentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function canCreate(): bool
    {
        return false; // Sembunyikan tombol "New"
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGeneratedDocuments::route('/'),
        ];
    }
}
