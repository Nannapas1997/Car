<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use App\Filament\Resources\InvoiceResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Arr;

class CreateInvoice extends CreateRecord
{
    protected static string $resource = InvoiceResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $invoiceItems = $this->data['invoiceItems'];
        $total = 0;
        $vatTotal = 0;

        foreach ($invoiceItems as $item) {
            if(Arr::get($item, 'amount')) {
                $total += Arr::get($item, 'amount');
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
}
