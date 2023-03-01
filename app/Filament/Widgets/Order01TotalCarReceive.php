<?php

namespace App\Filament\Widgets;

use App\Models\CarReceive;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class Order01TotalCarReceive extends BaseWidget
{
    protected static ?string $pollingInterval = '60s';

    protected function getCards(): array
    {
        $dateSelect = request()->query('date');

        if (!$dateSelect) {
            $dateSelect = Carbon::now()->format('Y-m-d');
        }

        $total = CarReceive::query()
            ->where('receive_date', $dateSelect)
            ->count();
        $pending = CarReceive::query()
            ->where('status', 'pending')
            ->where('receive_date', $dateSelect)
            ->count();
        $completed = CarReceive::query()
            ->where('status', 'completed')
            ->where('pickup_date', $dateSelect)
            ->count();

        return [
            Card::make('รายการทั้งหมด', $total)
                ->extraAttributes([
                    'class' => 'text-center text-xl',
                ]),
            Card::make('กำลังดำเนินการ', $pending)
                ->extraAttributes([
                    'class' => 'text-center text-xl',
                ]),
            Card::make('สำเร็จ', $completed)
                ->extraAttributes([
                    'class' => 'text-center text-xl',
                ]),
        ];
    }
}
