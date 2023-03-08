<?php

namespace App\Filament\Resources\EmployeeRequisitionResource\Widgets;

use App\Models\EmployeeRequisitionItem;
use Filament\Widgets\BarChartWidget;
use Illuminate\Support\Arr;

class EmployeeRequisitionChart extends BarChartWidget
{
    protected static ?string $heading = 'ใบเบิกเงินพนักงาน';
    protected int | string | array $columnSpan = 'full';
    protected static ?string $maxHeight = '250px';

    protected function getData(): array
    {
        $employees = EmployeeRequisitionItem::query()->get(['employee_lists', 'disbursement_amount']);
        $empLabel = [];
        $empValue = [];

        foreach ($employees->toArray() as $value) {
            $k = array_search(Arr::get($value, 'employee_lists'), $empLabel);

            if ($k === false) {
                $empLabel[] = Arr::get($value, 'employee_lists');
                $empValue[] = +Arr::get($value, 'disbursement_amount');
            } else {
                $empValue[$k] += +Arr::get($value, 'disbursement_amount');
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'จำนวนเงิน (บาท)',
                    'data' => $empValue,
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)'
                    ],
                    'borderColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)'
                    ],
                    'borderWidth' => 1
                ],
            ],
            'labels' => $empLabel,
        ];
    }
}
