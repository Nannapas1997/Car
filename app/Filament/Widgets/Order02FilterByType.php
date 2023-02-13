<?php

namespace App\Filament\Widgets;

use App\Models\CarReceive;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class Order02FilterByType extends BaseWidget
{
    protected static ?string $pollingInterval = '60s';

    protected function getCards(): array
    {
        $dateSelect = request()->query('date');

        if (!$dateSelect) {
            $dateSelect = Carbon::now()->format('Y-m-d');
        }

        $a = CarReceive::query()->where('repair_code', 'A')->where('receive_date', $dateSelect)->count();
        $b = CarReceive::query()->where('repair_code', 'B')->where('receive_date', $dateSelect)->count();
        $c = CarReceive::query()->where('repair_code', 'C')->where('receive_date', $dateSelect)->count();
        $d = CarReceive::query()->where('repair_code', 'D')->where('receive_date', $dateSelect)->count();

        return [
            Card::make('รหัสความเสียหาย A', $a)
                ->extraAttributes([
                    'class' => 'text-center text-xl',
                ]),
            Card::make('รหัสความเสียหาย B', $b)
                ->extraAttributes([
                    'class' => 'text-center text-xl',
                ]),
            Card::make('รหัสความเสียหาย C', $c)
                ->extraAttributes([
                    'class' => 'text-center text-xl',
                ]),
            Card::make('รหัสความเสียหาย D', $d)
                ->extraAttributes([
                    'class' => 'text-center text-xl',
                ]),
        ];
    }
}
