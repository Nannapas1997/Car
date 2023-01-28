<?php

namespace App\Filament\Widgets;

use App\Models\CarReceive;
use Filament\Widgets\Widget;

class DashBoardWidGet extends Widget
{
    protected static string $view = 'filament.widgets.dash-board-wid-get';

    protected function getViewData(): array
    {
        $exampleData = CarReceive::all()->toArray();
        $a = 0;
        $data_car = [];
        while($a < count($exampleData)){
            $data = $exampleData[$a]['repair_code'];

            $data_car[] = $data;
            ++$a;
        }
        $j =0;
        return [
            'data' => $data_car,
            'j' => $j,
            'total' => count($exampleData),
        ];
    }

}


