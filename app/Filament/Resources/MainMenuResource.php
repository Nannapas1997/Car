<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MainMenuResource\Pages;
use App\Filament\Resources\MainMenuResource\RelationManagers;
use App\Models\MainMenu;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MainMenuResource extends Resource
{
    protected static ?string $model = MainMenu::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationGroup = 'Main Menu';
   
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageMainMenus::route('/home'),
        ];
    }
}
