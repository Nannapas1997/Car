<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class Order00FilterCase extends BaseWidget
{
    protected static ?string $pollingInterval = '60s';
    protected int | string | array $columnSpan = 'full';

    protected function getCards(): array
    {
        return [
            Card::make('filter_date', '')
                ->view('custom.tailwind-datepicker'),
        ];
    }
}
