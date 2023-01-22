<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExampleCrudResource\Pages;
use App\Filament\Resources\ExampleCrudResource\RelationManagers;
use App\Models\ExampleCrud;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class ExampleCrudResource extends Resource
{
    protected static ?string $model = ExampleCrud::class;

    protected static ?string $navigationGroup = 'My Work';
    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('ชื่อ')
                    ->required(),
                FileUpload::make('image_url_1')
                    ->label('อัพโหลดรูปภาพ')
                    ->required()->minSize(10)->maxSize(1024)->image(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_url_1')
                    ->label('ชื่อ'),
                TextColumn::make('name')
                    ->label('รูปภาพ'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExampleCruds::route('/'),
            'create' => Pages\CreateExampleCrud::route('/create'),
            'edit' => Pages\EditExampleCrud::route('/{record}/edit'),
        ];
    }
}
