<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\InvoiceResource;

class EditInvoice extends EditRecord
{
    protected static string $resource = InvoiceResource::class;

    protected function getActions(): array
    {
        return [
            Action::make('print')
                ->label('print')
                ->openUrlInNewTab()
                ->viewData(['id' => $this->data['id']])
                ->view('prints.invoice-link'),
        ];
    }
}
