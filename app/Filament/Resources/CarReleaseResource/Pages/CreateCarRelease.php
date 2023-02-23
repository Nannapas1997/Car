<?php

namespace App\Filament\Resources\CarReleaseResource\Pages;

use App\Filament\Resources\CarReleaseResource;
use Filament\Facades\Filament;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Arr;

class CreateCarRelease extends CreateRecord
{
    protected static string $resource = CarReleaseResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        Arr::set($data, 'choose_garage', Filament::auth()->user()->garage);

        return $data;
    }
}
