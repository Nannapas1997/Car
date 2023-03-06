<?php

namespace App\Filament\Resources\PriceControlBillsResource\Pages;

use App\Filament\Resources\PriceControlBillsResource;
use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditPriceControlBills extends EditRecord
{
    protected static string $resource = PriceControlBillsResource::class;

    protected function getActions(): array
    {
        return [
            Action::make('print')
                ->label('พริ้น')
                ->openUrlInNewTab()
                ->viewData(['id' => $this->data['id']])
                ->view('prints.price-control-bill-link'),
        ];
    }
}
