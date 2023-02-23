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


        Arr::set($data, 'spare_cost', number_format($total, 2));

        return $data;
    }
}
