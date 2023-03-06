<?php

namespace App\Filament\Resources\EmployeeRequisitionResource\Pages;

use App\Filament\Resources\EmployeeRequisitionResource;
use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditEmployeeRequisition extends EditRecord
{
    protected static string $resource = EmployeeRequisitionResource::class;

    protected function getActions(): array
    {
        return [
            Action::make('print')
                ->label('พริ้น')
                ->openUrlInNewTab()
                ->viewData(['id' => $this->data['id']])
                ->view('prints.employee-requisition-link'),
        ];
    }
}
