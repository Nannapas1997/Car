<?php

namespace App\Filament\Resources\QuotationResource\Pages;

use App\Filament\Resources\QuotationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class CreateQuotation extends CreateRecord
{
    protected static string $resource = QuotationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $items = $this->data['quotationitems'];
        $total = 0;
        $includingSpareParts = 0;
        $wage = 0;
        $wageTotal = 0;
        $overAllPrice = count($items); // น่าจะเป็นจำนวนรายการนะ

        foreach ($items as $item) {
            $quantity = Arr::get($item, 'quantity', 1);

            if(
                Arr::get($item, 'spare_value') &&
                Arr::get($item, 'spare_code') != 'C6'
            ) {
                $includingSpareParts += Arr::get($item, 'spare_value') * $quantity;
            }

            if(Arr::get($item, 'price') && Arr::get($item, 'spare_code') == 'C6') {
                $wageTotal += Arr::get($item, 'spare_value');
            }

            if (Arr::get($item, 'spare_code') == 'C6' && Arr::get($item, 'wage')) {
                $quantity = 1;
            }

            if(
                Arr::get($item, 'spare_value')
            ) {
                $total += Arr::get($item, 'spare_value') * $quantity;
            }
        }
        $vat = 7/100;
        $vatTotal = $total * $vat;
        $sumTotal = $vatTotal + $total;

        Arr::set($data, 'overall_price', number_format(str_replace(',', '', $overAllPrice), 2));
        Arr::set($data, 'total_wage', number_format(str_replace(',', '', $wageTotal), 2));
        Arr::set($data, 'wage', number_format(str_replace(',', '', $wageTotal), 2));
        Arr::set($data, 'including_spare_parts', number_format(str_replace(',', '', $wageTotal), 2));
        Arr::set($data, 'vat', number_format(str_replace(',', '', $vatTotal), 2));
        Arr::set($data, 'overall', number_format(str_replace(',', '', $sumTotal), 2));
        Arr::set($data, 'spare_value', number_format(str_replace(',', '', $total), 2));

        return $data;
    }
}
