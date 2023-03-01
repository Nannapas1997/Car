<?php

namespace App\Filament\Resources\SaveRepairCostResource\Pages;

use Filament\Pages\Actions;
use Illuminate\Support\Arr;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\SaveRepairCostResource;

class CreateSaveRepairCost extends CreateRecord
{
    protected static string $resource = SaveRepairCostResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $save_repair_cost = $this->data['saveRepairCostItems'];
        $total = 0;

        foreach ($save_repair_cost as $item) {
            if(Arr::get($item, 'price')) {
                $total += Arr::get($item, 'price');
            }
        }

        Arr::set($data, 'total', number_format($total, 2));
        Arr::set($data, 'spare_cost', '0.00');
        Arr::set($data, 'wage', '0.00');
        Arr::set($data, 'expense_not_receipt', '0.00');

        return $data;
    }
}
