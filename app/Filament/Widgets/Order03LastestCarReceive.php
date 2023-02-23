<?php

namespace App\Filament\Widgets;

use App\Models\CarReceive;
use Carbon\Carbon;
use Closure;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use stdClass;

class Order03LastestCarReceive extends BaseWidget
{
    protected static ?string $pollingInterval = '60s';
    protected int | string | array $columnSpan = 'full';

    protected function getTableHeading(): string | Htmlable | Closure | null
    {
        return null;
    }

    protected function isTablePaginationEnabledWhileReordering(): bool
    {
        return true;
    }

    protected function getTableQuery(): Builder
    {
        $dateSelect = request()->query('date');

        if (!$dateSelect) {
            $dateSelect = Carbon::now()->format('Y-m-d');
        }

        return CarReceive::query()->where('receive_date', $dateSelect)->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('No.')->getStateUsing(static function (stdClass $rowLoop): string {
                return (string) $rowLoop->iteration;
            }),
            TextColumn::make('job_number')
                ->label(__('trans.job_number.text'))
                ->searchable()
                ->toggleable()
                ->sortable(),
            TextColumn::make('repairman')
                ->label(__('trans.repairman.text')),
            TextColumn::make('receive_date')
                ->label(__('trans.receive_date.text'))
                ->sortable()
                ->formatStateUsing(fn ($state): string => convertYmdToThaiShort($state)),
            TextColumn::make('pickup_date')
                ->label(__('trans.pickup_date.text'))
                ->sortable()
                ->formatStateUsing(fn ($state): string => convertYmdToThaiShort($state)),
            TextColumn::make('date_diff')
                ->label(__('trans.date_diff.text'))
                ->getStateUsing(static function ($record): string {
                    $a = Carbon::createFromFormat('Y-m-d', $record->receive_date);
                    $b = Carbon::createFromFormat('Y-m-d', $record->pickup_date);

                    return (string) $a->diffInDays($b);
                }),
            BadgeColumn::make('status')
                ->label(__('trans.status.text'))
                ->enum([
                    'pending' => 'ดำเนินการ',
                    'completed' => 'สำเร็จ',
                ]),
            TextColumn::make('attach_file')
                ->label(__('trans.attach_file.text')),
        ];
    }
}
