<?php

namespace App\Filament\Resources\Templates\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class FormFieldsRelationManager extends RelationManager
{
    protected static string $relationship = 'formFields';
    protected static ?string $title = 'Detail';

    public function form(Schema $schema): Schema
    {
        return $schema->schema([
            Forms\Components\TextInput::make('label')->required(),
            Forms\Components\TextInput::make('field_name')->required(),
            Forms\Components\Select::make('field_type')
                ->options([
                    'text' => 'Teks Singkat',
                    'textarea' => 'Paragraf',
                    'number' => 'Angka',
                    'date' => 'Tanggal',
                    'select' => 'Pilihan',
                ])
                ->required()
                ->live(),

            Forms\Components\Select::make('date_format')
                ->options([
                    'd-m-Y' => '01-12-2025',
                    'Y-m-d' => '2025-12-01',
                    'd F Y' => '01 Desember 2025',
                ])
                ->visible(fn ($get) => $get('field_type') === 'date'),

            Forms\Components\Textarea::make('options')
                ->visible(fn ($get) => $get('field_type') === 'select')
                ->helperText('Pisahkan dengan koma: Laki-laki,Perempuan'),

            Forms\Components\Radio::make('date_mode')
                ->label('Mode Tanggal')
                ->options([
                    'manual' => 'Manual',
                    'auto'   => 'Otomatis (tanggal generate)',
                ])
                ->default('manual')
                ->visible(fn ($get) => $get('field_type') === 'date'),

            Forms\Components\TextInput::make('order')->numeric()->default(1),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('label'),
                Tables\Columns\TextColumn::make('field_name'),
                Tables\Columns\TextColumn::make('field_type'),
                Tables\Columns\TextColumn::make('order')->label('Urutan'),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
