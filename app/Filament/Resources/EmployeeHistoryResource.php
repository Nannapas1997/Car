<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeHistoryResource\Pages;
use App\Filament\Resources\EmployeeHistoryResource\RelationManagers;
use App\Models\EmployeeHistory;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeHistoryResource extends Resource
{
    protected static ?string $model = EmployeeHistory::class;
    protected static ?string $navigationGroup = 'History';
    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

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
            'index' => Pages\ListEmployeeHistories::route('/'),
            'create' => Pages\CreateEmployeeHistory::route('/create'),
            'edit' => Pages\EditEmployeeHistory::route('/{record}/edit'),
        ];
    }
}
