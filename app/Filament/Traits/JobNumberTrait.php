<?php

namespace App\Filament\Traits;

use App\Models\CarReceive;
use Closure;
use Filament\Forms\Components\Select;
use Illuminate\Support\Arr;

trait JobNumberTrait
{
    public static function getViewData($currentGarage, Closure $closure): array
    {
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
                ->afterStateUpdated($closure),
        ];
    }
}
