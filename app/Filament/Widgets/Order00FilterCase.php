<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class Order00FilterCase extends BaseWidget
{
    protected static ?string $pollingInterval = '60s';
    protected int | string | array $columnSpan = 'full';

    protected function getCards(): array
    {
        $queryDate = request()->query('date');
        $currentDate = '';

        if ($queryDate) {
            $currentDate = convertYmdToThaiMonthOnly(Carbon::createFromFormat('Y-m-d', $queryDate)->format('Y-m-d'));
        }

        return [
            Card::make('filter_date', '')
                ->view('custom.tailwind-datepicker', [
                    'currentDate' => $currentDate
                ]),
        ];
    }
}
