<?php

namespace App\Filament\Resources\EmployeeRequisitionResource\Pages;

use App\Filament\Resources\EmployeeRequisitionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmployeeRequisitions extends ListRecords
{
    protected static string $resource = EmployeeRequisitionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
