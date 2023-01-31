<?php

namespace App\Filament\Resources\SaveRepairCostsResource\Pages;

use App\Filament\Resources\SaveRepairCostsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSaveRepairCosts extends ListRecords
{
    protected static string $resource = SaveRepairCostsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
