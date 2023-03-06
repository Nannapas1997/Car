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
        $vat = 0;
        $total = 0;

        if ($this->data['choose_vat_or_not'] == 'vat_include_yes') {
            $vat = $amount * (7/100);
        }

        $total = $amount + $vat;

        Arr::set($data, 'aggregate', number_format(str_replace(',', '', $total), 2));
        Arr::set($data, 'vat', number_format(str_replace(',', '', $vat), 2));

        return $data;
    }

    protected function getActions(): array
    {
        return [
            Action::make('print')
                ->label('พริ้น')
                ->openUrlInNewTab()
                ->viewData(['id' => $this->data['id']])
                ->view('prints.bill-link'),
        ];
    }
}
