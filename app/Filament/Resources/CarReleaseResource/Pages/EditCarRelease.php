<?php

namespace App\Filament\Resources\CarReleaseResource\Pages;

use Filament\Pages\Actions;
use Filament\Facades\Filament;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\CarReleaseResource;

class EditCarRelease extends EditRecord
{
    protected static string $resource = CarReleaseResource::class;

    protected function getActions(): array
    {
        $currentGarage = Filament::auth()->user()->garage;
        dd($currentGarage);
        if($currentGarage == 'SP'){
            return [
                Action::make('print')
                    ->label('print')
                    ->openUrlInNewTab()
                    ->viewData(['id' => $this->data['id']])
                    ->view('prints.car-release-link'),
            ];
        }elseif($currentGarage == 'SBO') {
            return [
                Action::make('print')
                    ->label('print')
                    ->openUrlInNewTab()
                    ->viewData(['id' => $this->data['id']])
                    ->view('prints.SBO-car-release-link'),
            ];
        }
    }
}
