<?php

namespace App\Filament\Widgets;

use App\Models\CarReceive;
use Filament\Widgets\Widget;

class DashBoardWidGet extends Widget
{
    protected static string $view = 'filament.widgets.dash-board-wid-get';

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

        return [
            'a' => $a,
            'b' => $b,
            'c' => $c,
            'd' => $d,
            'total' => $a + $b + $c + $d,
        ];
    }
}
