<?php

namespace App\Filament\Resources\FollowWorkResource\Widgets;


use App\Models\CarReceive;
use Filament\Widgets\Widget;

class FollowWork extends Widget
{
    protected static string $view = 'filament.resources.follow-work-resource.widgets.follow-work';

    public static function getWidget():array
    {
        return [
            Widgets\FollowWork::class,
        ];
    }
    protected function getViewData(): array
    {
        $b = CarReceive::query()
            ->where('pickup_date', '=', now()->format('Y-m-d'))
            ->count();
        $a = 0;
        $data = CarReceive::pluck('receive_date');
        for($i = 0 ; $i < count($data); $i++){
            if(CarReceive::pluck('pickup_date')[$i] !== now()->format('Y-m-d')){
                ++$a;
            }else{
                continue;
            }
        }

        return [
            'a' => $a,
            'b' => $b,
            'total' => $a + $b,
        ];
    }
}


