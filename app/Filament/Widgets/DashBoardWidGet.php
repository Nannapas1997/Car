<?php

namespace App\Filament\Widgets;

use App\Models\ExampleCrud;
use Filament\Widgets\Widget;

class DashBoardWidGet extends Widget
{
    protected static string $view = 'filament.widgets.dash-board-wid-get';

    protected function getViewData(): array
    {
        $exampleData = ExampleCrud::all()->toArray();

        return [
            'data' => $exampleData,
            'total' => count($exampleData)
        ];
    }
}
