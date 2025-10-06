<?php

namespace App\Filament\Resources\Templates;

use App\Filament\Resources\Templates\Pages\CreateTemplate;
use App\Filament\Resources\Templates\Pages\EditTemplate;
use App\Filament\Resources\Templates\Pages\ListTemplates;
use App\Filament\Resources\Templates\Schemas\TemplateForm;
use App\Filament\Resources\Templates\Tables\TemplatesTable;
use App\Filament\Resources\Templates\RelationManagers\FormFieldsRelationManager;
use App\Models\Template;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class TemplateResource extends Resource
{
    protected static ?string $model = Template::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string|null|\BackedEnum $navigationIcon = 'heroicon-o-document-duplicate';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema(TemplateForm::schema());
    }

    public static function table(Table $table): Table
    {
        return TemplatesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            FormFieldsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTemplates::route('/'),
            'create' => CreateTemplate::route('/create'),
            'edit' => EditTemplate::route('/{record}/edit'),
        ];
    }
}
