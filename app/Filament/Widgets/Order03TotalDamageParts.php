<?php

use App\Models\CarReceive;
use Filament\Widgets\Widget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class Order03TotalDamageParts extends Widget
{
    protected function getViewData(): array
    {
        $a = CarReceive::query()
        ->where('repair_code', '=', 'A')
        ->count();
        $b = CarReceive::query()
        ->where('repair_code', '=', 'B')
        ->count();
        $c = CarReceive::query()
        ->where('repair_code', '=', 'C')
        ->count();
        $d = CarReceive::query()
        ->where('repair_code', '=', 'D')
        ->count();
        return[
            'a' => $a,
            'b' => $b,
            'c' => $c,
            'd' => $d,
            'total' => $a + $b + $c + $d,
        ];
    }

}
