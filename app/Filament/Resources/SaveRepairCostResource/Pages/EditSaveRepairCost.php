<?php

namespace App\Filament\Resources\SaveRepairCostResource\Pages;

use App\Filament\Resources\SaveRepairCostResource;
use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Arr;

class EditSaveRepairCost extends EditRecord
{
    protected static string $resource = SaveRepairCostResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $save_repair_cost = $this->data['saveRepairCostItems'];
        $total = 0;

        foreach ($save_repair_cost as $item) {
            if(Arr::get($item, 'price')) {
                $total += Arr::get($item, 'price');
            }
        }

        Arr::set($data, 'total', number_format(str_replace(',', '', $total), 2));
        Arr::set($data, 'spare_cost', '0.00');
        Arr::set($data, 'wage', '0.00');
        Arr::set($data, 'expense_not_receipt', '0.00');

        return $data;
    }

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Action::make('print')
                ->label('พริ้น')
                ->openUrlInNewTab()
                ->viewData(['id' => $this->data['id']])
                ->view('prints.save-repair-cost-link'),
        ];
    }
}
