<?php

namespace App\Filament\Resources\SaveRepairCostsResource\Pages;

use App\Filament\Resources\SaveRepairCostsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSaveRepairCosts extends EditRecord
{
    protected static string $resource = SaveRepairCostsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
