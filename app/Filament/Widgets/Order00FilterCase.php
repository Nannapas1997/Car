<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Facades\Log;

class Order00FilterCase extends BaseWidget
{
    protected static ?string $pollingInterval = '60s';
    protected int | string | array $columnSpan = 'full';

    protected function getCards(): array
    {
        $dateSelect = request()->query('date');

        if (!$dateSelect) {
            $dateSelect = Carbon::now()->format('Y-m-d');
        }

        return [
            Card::make('filter_date', '')
                ->view('custom.tailwind-datepicker'),
        ];
    }
}
