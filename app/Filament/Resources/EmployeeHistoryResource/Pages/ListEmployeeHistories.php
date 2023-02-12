<?php

namespace App\Filament\Resources\EmployeeHistoryResource\Pages;

use App\Filament\Resources\EmployeeHistoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmployeeHistories extends ListRecords
{
    protected static string $resource = EmployeeHistoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
