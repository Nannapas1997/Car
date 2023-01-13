<?php

namespace App\Filament\Resources\MainMenuResource\Pages;

use App\Filament\Resources\MainMenuResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageMainMenus extends ManageRecords
{
    protected static string $resource = MainMenuResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
