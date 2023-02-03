<?php

namespace App\Filament\Resources\CarReleaseResource\Pages;

use App\Filament\Resources\CarReleaseResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCarReleases extends ListRecords
{
    protected static string $resource = CarReleaseResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
