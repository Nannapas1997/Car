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
        $overAllPrice = count($items); // น่าจะเป็นจำนวนรายการนะ

        foreach ($items as $item) {
            $quantity = Arr::get($item, 'quantity', 1);

            if(
                Arr::get($item, 'spare_value') &&
                Arr::get($item, 'code_c0_c7') != 'C6'
            ) {
                $includingSpareParts += Arr::get($item, 'spare_value') * $quantity;
            }

            if(Arr::get($item, 'spare_value') && Arr::get($item, 'code_c0_c7') == 'C6') {
                $wage += Arr::get($item, 'spare_value');
            }

            if (Arr::get($item, 'code_c0_c7') == 'C6') {
                $quantity = 1;
            }

            if(
                Arr::get($item, 'spare_value')
            ) {
                $total += Arr::get($item, 'spare_value') * $quantity;
            }
        }

        $vatTotal = $total * (7/100);
        $sumTotal = $vatTotal + $total;

        Arr::set($data, 'overall_price', number_format($overAllPrice, 0));
        Arr::set($data, 'total_wage', number_format($wage, 2));
        Arr::set($data, 'including_spare_parts', number_format($includingSpareParts, 2));
        Arr::set($data, 'total_wage', number_format($sumTotal, 2));

        Log::info('CAL_VAT', $data);

        return $data;
    }
}
