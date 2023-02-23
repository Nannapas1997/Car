<?php

namespace App\Filament\Resources\CarReleaseResource\Pages;

use App\Filament\Resources\CarReleaseResource;
use Filament\Facades\Filament;
use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Arr;

class EditCarRelease extends EditRecord
{
    protected static string $resource = CarReleaseResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        Arr::set($data, 'choose_garage', Filament::auth()->user()->garage);

        return $data;
    }

    protected function getActions(): array
    {
        return [
            Action::make('print')
                ->label('print')
                ->openUrlInNewTab()
                ->viewData(['id' => $this->data['id']])
                ->view('prints.car-release-link'),
        ];
    }
}
