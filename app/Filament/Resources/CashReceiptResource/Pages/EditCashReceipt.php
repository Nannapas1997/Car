<?php

namespace App\Filament\Resources\CashReceiptResource\Pages;

use App\Filament\Resources\CashReceiptResource;
use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditCashReceipt extends EditRecord
{
    protected static string $resource = CashReceiptResource::class;

    protected function getActions(): array
    {
        return [
            Action::make('print')
                ->label('พริ้น')
                ->openUrlInNewTab()
                ->viewData(['id' => $this->data['id']])
                ->view('prints.cash-receipt-link'),
        ];
    }
}
