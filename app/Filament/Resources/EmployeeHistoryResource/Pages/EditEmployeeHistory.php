<?php

namespace App\Filament\Resources\EmployeeHistoryResource\Pages;

use App\Filament\Resources\EmployeeHistoryResource;
use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditEmployeeHistory extends EditRecord
{
    protected static string $resource = EmployeeHistoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
