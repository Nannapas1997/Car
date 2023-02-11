<?php

namespace App\Filament\Resources\CashReceiptResource\Pages;

use App\Filament\Resources\CashReceiptResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCashReceipts extends ListRecords
{
    protected static string $resource = CashReceiptResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
