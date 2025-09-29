<?php

namespace App\Filament\Resources\FormFields;

use App\Filament\Resources\FormFields\Pages\CreateFormField;
use App\Filament\Resources\FormFields\Pages\EditFormField;
use App\Filament\Resources\FormFields\Pages\ListFormFields;
use App\Filament\Resources\FormFields\Schemas\FormFieldForm;
use App\Filament\Resources\FormFields\Tables\FormFieldsTable;
use App\Models\FormField;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class FormFieldResource extends Resource
{
    protected static ?string $model = FormField::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return FormFieldForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FormFieldsTable::configure($table);
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
        return false; // Sembunyikan tombol "Edit" di tabel
    }

    public static function getPages(): array
    {
        return [
            // Hanya izinkan halaman daftar (List)
            'index' => Pages\ListFormFields::route('/'),
        ];
    }
}
