<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CashReceiptResource\Pages;
use App\Filament\Resources\CashReceiptResource\RelationManagers;
use App\Models\CashReceipt;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CashReceiptResource extends Resource
{
    protected static ?string $model = CashReceipt::class;
    protected static ?string $navigationGroup = 'Financial';
    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListCashReceipts::route('/'),
            'create' => Pages\CreateCashReceipt::route('/create'),
            'edit' => Pages\EditCashReceipt::route('/{record}/edit'),
        ];
    }
}
