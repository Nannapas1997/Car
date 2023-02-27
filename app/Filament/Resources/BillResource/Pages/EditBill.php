<?php

namespace App\Filament\Resources\BillResource\Pages;

use App\Filament\Resources\BillResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Arr;

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
            Actions\DeleteAction::make(),
        ];
    }
}
