<?php

namespace App\Filament\Resources\ใบรับรถResource\Pages;

use App\Filament\Resources\ใบรับรถResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class Manageใบรับรถs extends ManageRecords
{
    protected static string $resource = ใบรับรถResource::class;

    protected function getActions(): array
    {
        
        return [
            Actions\CreateAction::make(),
        ];
    }
}
