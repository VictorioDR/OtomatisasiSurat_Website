<?php

namespace App\Filament\Resources\GeneratedDocuments\Pages;

use App\Filament\Resources\GeneratedDocuments\GeneratedDocumentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditGeneratedDocument extends EditRecord
{
    protected static string $resource = GeneratedDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
