<?php

namespace App\Filament\Resources\ExampleCrudResource\Pages;

use App\Filament\Resources\ExampleCrudResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExampleCruds extends ListRecords
{
    protected static string $resource = ExampleCrudResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
