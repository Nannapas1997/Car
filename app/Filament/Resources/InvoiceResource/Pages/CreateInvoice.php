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

        foreach ($invoiceItems as $item) {
            if(Arr::get($item, 'price')) {
                $total += Arr::get($item, 'price');
            }
        }

        $vatTotal = $total * (7/100);

        Arr::set($data, 'amount', number_format($total, 2));
        Arr::set($data, 'vat', number_format($vatTotal, 2));
        Arr::set($data, 'aggregate', number_format($total + $vatTotal, 2));

        return $data;
    }
}
