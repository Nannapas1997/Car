<?php

namespace App\Filament\Resources\BillResource\Pages;

use Filament\Pages\Actions;
use Illuminate\Support\Arr;
use Filament\Pages\Actions\Action;
use App\Filament\Resources\BillResource;
use Filament\Resources\Pages\EditRecord;

class EditBill extends EditRecord
{
    protected static string $resource = BillResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $amount = $this->data['amount'] ? $this->data['amount'] : 0;
        $vat = $amount * (7/100);
        $total = $amount + $vat;

        Arr::set($data, 'aggregate', number_format($total, 2));
        Arr::set($data, 'vat', number_format($vat, 2));

        return $data;
    }

    protected function getActions(): array
    {
        return [
            Action::make('print')
                ->label('print')
                ->openUrlInNewTab()
                ->viewData(['id' => $this->data['id']])
                ->view('prints.car-receive-link'),
        ];
    }
}
