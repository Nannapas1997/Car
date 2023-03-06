<?php

namespace App\Filament\Traits;

use App\Models\CarReceive;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Illuminate\Support\Arr;

trait JobNumberTrait
{
    public static function getViewData(): array{
        $currentGarage =  Filament::auth()->user()->garage;
        $optionData = CarReceive::query()
            ->where('choose_garage', $currentGarage)
            ->orderBy('job_number', 'desc')
            ->get('job_number')
            ->pluck('job_number', 'job_number')
            ->toArray();

        $optionValue = [];

        $lastValue = Arr::first($optionData);

        if ($lastValue) {
            $lastValueExplode = explode('-', $lastValue);
            $lastValue = intval($lastValueExplode[count($lastValueExplode) - 1]);
            $lastValue += 1;
            $lastValue = $lastValue < 10 ? "0000{$lastValue}" :
                ($lastValue < 100 ? "000{$lastValue}" :
                    ($lastValue < 1000 ? "00{$lastValue}" :
                        ($lastValue < 10000 ? "0{$lastValue}" : $lastValue)));

            $lastValue = $currentGarage . now()->format('-y-m-d-') . $lastValue;
            $optionValue[$lastValue] = $lastValue;
        }

        foreach ($optionData as $val) {
            $optionValue[$val] = $val;
        }

        return [
            Select::make('job_number')
                ->label(' ' . __('trans.job_number.text') . ' ' . __('trans.current_garage.text') . $currentGarage)
                ->preload()
                ->required()
                ->searchable()
                ->options($optionData)
                ->reactive()
                ->afterStateUpdated(function ($set, $state) use ($currentGarage) {
                    if ($state) {
                        $name = CarReceive::query()->where('job_number', $state)->first();
                        if ($name) {
                            $name = $name->toArray();
                            $set('vehicle_registration', $name['vehicle_registration']);
                            $set('customer', $name['customer']);
                            $set('choose_garage', $currentGarage);
                        }
                    }
                }),
        ];
    }
}
