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
        $a = CarReceive::query()
            ->where('receive_date', '=', now()->format('Y-m-d'))
            ->count();
        $b = CarReceive::query()
            ->where('pickup_date', '=', now()->format('Y-m-d'))
            ->count();
        return [
            'a' => $a,
            'b' => $b,
            'total' => $a + $b,
        ];
    }
}


