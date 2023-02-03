<?php

namespace App\Filament\Resources\CarReleaseResource\Pages;

use App\Filament\Resources\CarReleaseResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCarRelease extends EditRecord
{
    protected static string $resource = CarReleaseResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
