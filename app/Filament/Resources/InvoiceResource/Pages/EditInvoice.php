<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\InvoiceResource;
use Illuminate\Support\Arr;

class EditInvoice extends EditRecord
{
    protected static string $resource = InvoiceResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $invoiceItems = $this->data['invoiceItems'];
        $total = 0;
        $vatTotal = 0;

        foreach ($invoiceItems as $item) {
            if(Arr::get($item, 'price')) {
                $total += Arr::get($item, 'price');
            }
        }

        if ($this->data['choose_vat_or_not'] == 'vat_include_yes') {
            $vatTotal = $total * (7/100);
        }

        Arr::set($data, 'amount', number_format($total, 2));
        Arr::set($data, 'vat', number_format($vatTotal, 2));
        Arr::set($data, 'aggregate', number_format($total + $vatTotal, 2));
        Arr::set($data, 'choose_vat_or_not', $this->data['choose_vat_or_not']);

        return $data;
    }

    protected function getActions(): array
    {
        return [
            Action::make('print')
                ->label('พริ้น')
                ->openUrlInNewTab()
                ->viewData(['id' => $this->data['id']])
                ->view('prints.invoice-link'),
        ];
    }
}
