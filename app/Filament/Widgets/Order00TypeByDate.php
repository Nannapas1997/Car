<?php

namespace App\Filament\Widgets;

use App\Models\CarReceive;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class Order00TypeByDate extends BaseWidget
{
    protected static ?string $pollingInterval = '60s';

    protected function getCards(): array
    {
        $dateSelect = request()->query('date');

        if (!$dateSelect) {
            $dateSelect = Carbon::now()->format('Y-m-d');
        }

        // $dateSelect = 2023-02-13
        // % call
        // 2023-02-%
        // 2023-%
        // 2023-02-13

        $dateArr = explode('-', $dateSelect);
        $month = $dateArr[1] < 10 ? '0' . $dateArr[1] : $dateArr[1];

        $year = CarReceive::query()->where('receive_date', 'like', $dateArr[0] . '-%')->get();
        $yearA = $year->where('repair_code', 'A')->count();
        $yearB = $year->where('repair_code', 'B')->count();
        $yearC = $year->where('repair_code', 'C')->count();
        $yearD = $year->where('repair_code', 'D')->count();
        $yearTotal = $year->count();

        $month = CarReceive::query()->where('receive_date', 'like', $dateArr[0] . '-' . $month . '-%')->get();
        $monthA = $month->where('repair_code', 'A')->count();
        $monthB = $month->where('repair_code', 'B')->count();
        $monthC = $month->where('repair_code', 'C')->count();
        $monthD = $month->where('repair_code', 'D')->count();
        $monthTotal = $month->count();

        $day = CarReceive::query()->where('receive_date', $dateSelect)->get();
        $dayA = $day->where('repair_code', 'A')->count();
        $dayB = $day->where('repair_code', 'B')->count();
        $dayC = $day->where('repair_code', 'C')->count();
        $dayD = $day->where('repair_code', 'D')->count();
        $dayTotal = $day->count();

        return [
            Card::make('ปี', '')
                ->view('custom.car-receive-type-sum', [
                    'type' => 'ปี',
                    'total' => $yearTotal,
                    'a' => $yearA,
                    'b' => $yearB,
                    'c' => $yearC,
                    'd' => $yearD,
                ]),
            Card::make('เดือน', '')
                ->view('custom.car-receive-type-sum', [
                    'type' => 'เดือน',
                    'total' => $monthTotal,
                    'a' => $monthA,
                    'b' => $monthB,
                    'c' => $monthC,
                    'd' => $monthD,
                ]),

            Card::make('วัน', '')
                ->view('custom.car-receive-type-sum', [
                    'type' => 'วัน',
                    'total' => $dayTotal,
                    'a' => $dayA,
                    'b' => $dayB,
                    'c' => $dayC,
                    'd' => $dayD,
                ]),
        ];
    }
}
