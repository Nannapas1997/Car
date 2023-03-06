<?php

namespace App\Filament\Resources\CarReceiveResource\Pages;

use App\Filament\Resources\CarReceiveResource;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditCarReceive extends EditRecord
{
    protected static string $resource = CarReceiveResource::class;

    protected function getActions(): array
    {
        return [
            Action::make('print')
                ->label('พริ้น')
                ->openUrlInNewTab()
                ->viewData(['id' => $this->data['id']])
                ->view('prints.car-receive-link'),
        ];
    }
}
