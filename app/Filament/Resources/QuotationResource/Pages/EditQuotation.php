<?php

namespace App\Filament\Resources\QuotationResource\Pages;

use App\Filament\Resources\QuotationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class EditQuotation extends EditRecord
{
    protected static string $resource = QuotationResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $items = $this->data['quotationitems'];
        $total = 0;
        $includingSpareParts = 0;
        $wage = 0;
        $overAllPrice = count($items); // น่าจะเป็นจำนวนรายการนะ

        foreach ($items as $item) {
            $quantity = Arr::get($item, 'quantity', 1);

            if(
                Arr::get($item, 'price') &&
                Arr::get($item, 'code_c0_c7') != 'C6'
            ) {
                $includingSpareParts += Arr::get($item, 'price') * $quantity;
            }

            if(Arr::get($item, 'price') && Arr::get($item, 'spare_code') == 'C6') {
                $wage += Arr::get($item, 'price');
            }

            if (Arr::get($item, 'spare_code') == 'C6') {
                $quantity = 1;
            }

            if(
                Arr::get($item, 'price')
            ) {
                $total += Arr::get($item, 'price') * $quantity;
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

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
