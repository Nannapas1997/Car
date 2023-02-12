<?php

namespace App\Filament\Widgets;

use App\Models\CarReceive;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class Order01TotalCarReceive extends BaseWidget
{
    protected function getCards(): array
    {
        $total = CarReceive::query()->count();
        $pending = CarReceive::query()->where('status', 'pending')->count();
        $completed = CarReceive::query()->where('status', 'completed')->count();

        return [
            Card::make('รายการทั้งหมด', $total),
            Card::make('กำลังดำเนินการ', $pending),
            Card::make('สำเร็จ', $completed),
        ];
    }
}
