<?php

namespace App\Filament\Resources\CarReceiveResource\Widgets;

use App\Models\CarReceive;
use Filament\Widgets\Widget;
$SP = "SP";
$SBO = "SBO";
$day = now()->format('y-m-d');
$j = 1;
$str = "-000";
for($i=0;$i<= 1000;$i++) {
    $total_sp[] = $SP.''.$day.''.$str.''.$j;
}
class carReceives extends Widget
{
    protected static string $view = 'filament.resources.car-receive-resource.widgets.car-receives';
    public static function getWidget():array
    {
        return [
            Widgets\carReceives::class,
        ];
    }
    protected function getViewData(): array
    {   $SP = "SP";
        $SBO = "SBO";
        $day = now()->format('y-m-d');
        $j = 1;
        $str = "-000";
        for($i=0;$i<= 1000;$i++) {
            $total_sp[] = $SP.''.$day.''.$str.''.$j;
        }

        return [
            'total_sp' => $total_sp,
        ];
    }
}
