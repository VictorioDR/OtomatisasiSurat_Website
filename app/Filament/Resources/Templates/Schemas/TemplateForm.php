<?php

namespace App\Filament\Resources\Templates\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Placeholder;
use Illuminate\Support\HtmlString;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Hint;

class TemplateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),

                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Textarea::make('description')
                    ->rows(3)
                    ->columnSpanFull(),

                FileUpload::make('file_path')
                    ->label('Upload Template (.docx)')
                    ->directory('templates') // Akan disimpan di storage/app/public/templates
                    ->disk('public')
                    ->preserveFilenames()
                    ->acceptedFileTypes(['application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                    ->required(),

                Toggle::make('is_public')
                    ->label('Public')
                    ->required()
                    ->default(false),

                Repeater::make('form_fields')
                    ->label('Fields')
                    ->relationship('formFields')
                    ->schema([
                        TextInput::make('label')
                            ->required()
                            ->label('Label'),

                        TextInput::make('field_name')
                            ->required()
                            ->label('Field Name'),

                        Select::make('field_type')
                            ->options([
                                'text' => 'Text',
                                'textarea' => 'Textarea',
                                'date' => 'Date',
                                'select' => 'Select',
                                'number' => 'Number',
                            ])
                            ->required()
                            ->live()
                            ->label('Field Type'),

                        Textarea::make('options')
                            ->label('Options')
                            ->rows(2)
                            ->helperText('Untuk Tipe Select, pisahkan dengan koma. Cth: Pria,Wanita')
                            ->visible(fn (string $context) => $context === 'create' || $context === 'edit'),

                        TextInput::make('date_format')
                            ->label('Date Format')
                            ->placeholder('d/m/Y')
                            ->helperText('Gunakan format tanggal dari PHP. Cth: d F Y')
                            ->visible(fn ($get) => $get('field_type') === 'date'),

                        Placeholder::make('date-format-hint')
                            ->label('') // kosongkan label
                            ->content(new HtmlString(
                                '<div style="font-size: 0.875rem; color: #9ca3af;">' .
                                '<strong>Contoh Populer:</strong>' .
                                '<ul style="list-style-type: disc; padding-left: 20px; margin-top: 4px;">' .
                                '<li><strong>d F Y</strong> → 26 September 2025 (Direkomendasikan)</li>' .
                                '<li><strong>d-m-Y</strong> → 26-09-2025</li>' .
                                '<li><strong>l, d F Y</strong> → Jumat, 26 September 2025</li>' .
                                '</ul>' .
                                '</div>'
                            ))
                            ->visible(fn ($get) => $get('field_type') === 'date'),

                        Toggle::make('is_required')
                            ->label('Required'),

                        TextInput::make('order')
                            ->numeric()
                            ->label('Order')
                            ->default(1),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->defaultItems(1),

                Hidden::make('user_id')->default(auth()->id()),
            ]);
    }
}
