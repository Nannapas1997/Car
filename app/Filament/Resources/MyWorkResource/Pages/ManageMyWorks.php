<?php

namespace App\Filament\Resources\MyWorkResource\Pages;

use App\Filament\Resources\MyWorkResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageMyWorks extends ManageRecords
{
    protected static string $resource = MyWorkResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
