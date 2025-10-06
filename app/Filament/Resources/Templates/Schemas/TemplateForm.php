<?php

namespace App\Filament\Resources\Templates\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class TemplateForm
{
    public static function schema(): array
    {
        return [
            TextInput::make('name')
                ->label('Nama Template')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),

            Textarea::make('description')
                ->label('Deskripsi (Opsional)')
                ->rows(3)
                ->columnSpanFull(),

            FileUpload::make('original_file_path')
                ->label('Upload File Template (.docx)')
                ->directory('templates')
                ->disk('public')
                ->preserveFilenames()
                ->acceptedFileTypes(['application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                ->required()
                ->columnSpanFull(),
        ];
    }
}
