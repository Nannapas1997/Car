<?php

namespace App\Filament\Resources\ApprovalRequestResource\Pages;

use App\Filament\Resources\ApprovalRequestResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListApprovalRequests extends ListRecords
{
    protected static string $resource = ApprovalRequestResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
