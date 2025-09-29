<?php

namespace App\Filament\Resources\GeneratedDocuments\Pages;

use App\Filament\Resources\GeneratedDocuments\GeneratedDocumentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGeneratedDocuments extends ListRecords
{
    protected static string $resource = GeneratedDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
