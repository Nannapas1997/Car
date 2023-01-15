<?php

namespace App\Filament\Resources\CarReceiveResource\Pages;

use App\Filament\Resources\CarReceiveResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCarReceives extends ListRecords
{
    protected static string $resource = CarReceiveResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
