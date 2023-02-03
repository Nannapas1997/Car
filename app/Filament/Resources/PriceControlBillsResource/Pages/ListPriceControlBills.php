<?php

namespace App\Filament\Resources\PriceControlBillsResource\Pages;

use App\Filament\Resources\PriceControlBillsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPriceControlBills extends ListRecords
{
    protected static string $resource = PriceControlBillsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
   
}
