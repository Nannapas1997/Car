<?php

namespace App\Filament\Resources\SaveRepairCostResource\Pages;

use App\Filament\Resources\SaveRepairCostResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSaveRepairCosts extends ListRecords
{
    protected static string $resource = SaveRepairCostResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
