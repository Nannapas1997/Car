<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Forms;
use Filament\Tables;
use App\Models\Invoice;
use App\Models\CarReceive;
use Illuminate\Support\Arr;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Facades\Filament;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use App\Filament\Resources\InvoiceResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\InvoiceResource\RelationManagers;
use PhpParser\Node\Stmt\Label;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;
    protected static ?string $navigationGroup = 'Account';
    protected static ?string $navigationIcon = 'heroicon-o-document-add';

    public int $totalAmount = 0;

    public static function getViewData(): array{
        $currentGarage =  Filament::auth()->user()->garage;
        $optionData = CarReceive::query()
            ->where('choose_garage', $currentGarage)
            ->orderBy('job_number', 'desc')
            ->get('job_number')
            ->pluck('job_number', 'job_number')
            ->toArray();
        $optionValue = [];

        if (!$optionData) {
            $jobNumberFirst = $currentGarage . now()->format('-y-m-d-') . '0001';
            $optionValue[$jobNumberFirst] = $jobNumberFirst;
        } else {
            $lastValue = Arr::first($optionData);

            if ($lastValue) {
                $lastValueExplode = explode('-', $lastValue);
                $lastValue = intval($lastValueExplode[count($lastValueExplode) - 1]);
                $lastValue += 1;
                $lastValue = $lastValue < 10 ? "0000{$lastValue}" :
                    ($lastValue < 100 ? "000{$lastValue}" :
                        ($lastValue < 1000 ? "00{$lastValue}" :
                            ($lastValue < 10000 ? "0{$lastValue}" : $lastValue)));

                $lastValue = $currentGarage . now()->format('-y-m-d-') . $lastValue;
                $optionValue[$lastValue] = $lastValue;
            }

            foreach ($optionData as $val) {
                $optionValue[$val] = $val;
            }
        }

        return [
            Select::make('job_number')
                ->label(' ' . __('trans.job_number.text') . ' ' . __('trans.current_garage.text') . $currentGarage)
                ->preload()
                ->required()
                ->searchable()
                ->options($optionData)
                ->reactive()
                ->afterStateUpdated(function ($set, $state) {
                    if ($state) {
                        $name = CarReceive::query()->where('job_number', $state)->first();
                        if ($name) {
                            $name = $name->toArray();
                            $set('vehicle_registration', $name['vehicle_registration']);
                            $set('customer', $name['customer']);
                        }
                    }
                }),
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema(static::getViewData('job_number')),
                TextInput::make('customer')->label(__('trans.customer.text'))->required(),
                TextInput::make('invoice_number')->label(__('trans.invoice_number.text'))->required(),
                TextInput::make('good_code')->label(__('trans.good_code.text'))->required(),
                TextInput::make('vehicle_registration')->label(__('trans.vehicle_registration.text'))->required(),
                Card::make()
                    ->schema([
                        Placeholder::make('รายการค่าใช้จ่าย'),
                        Repeater::make('invoiceItems')
                            ->reactive()
                            ->relationship()
                            ->schema(
                                [
                                    Select::make('code_c0_c7')->label(__('trans.code_c0_c7.text'))
                                    ->options([
                                        'C0' => 'C0',
                                        'C1' => 'C1',
                                        'C2' => 'C2',
                                        'C3' => 'C3',
                                        'C4' => 'C4',
                                        'C5' => 'C5',
                                        'C6' => 'C6',
                                        'C7' => 'C7',
                                    ])
                                    ->required()
                                    ->reactive()
                                    ->columnSpan([
                                        'md' => 2,
                                    ]),
                                    TextInput::make('price')
                                        ->label(__('trans.price.text'))
                                        ->columnSpan([
                                            'md' => 3,
                                        ])
                                        ->required(),
                                    TextInput::make('spare_code')->label(__('trans.spare_code.text'))
                                    ->columnSpan([
                                        'md' => 3,
                                    ])->required(),
                                ])
                            ->defaultItems(count: 1)
                            ->columns(['md' => 8,])
                            ->createItemButtonLabel('เพิ่มรายการค่าใช้จ่าย'),
                        ])->columnSpan('full'),
                    TextInput::make('amount_display')
                        ->label(__('trans.amount.text'))
                        ->disabled()
                        ->placeholder(function (Closure $get) {
                            $invoiceItems = $get('invoiceItems');
                            $total = 0;

                            foreach ($invoiceItems as $item) {
                                if(Arr::get($item, 'price')) {
                                    $total += Arr::get($item, 'price');
                                }
                            }

                            return $total ? number_format($total, 2) : '0.00';
                        }),
                    TextInput::make('vat_display')
                        ->label(__('trans.vat.text'))
                        ->disabled()
                        ->placeholder(function (Closure $get) {
                            $invoiceItems = $get('invoiceItems');
                            $total = 0;

                            foreach ($invoiceItems as $item) {
                                if(Arr::get($item, 'price')) {
                                    $total += Arr::get($item, 'price');
                                }
                            }

                            $vatTotal = $total * (7/100);

                            return $vatTotal ? number_format($vatTotal, 2) : '0.00';
                        }),
                    TextInput::make('aggregate_display')
                        ->label(__('trans.aggregate.text'))
                        ->disabled()
                        ->placeholder(function (Closure $get) {
                            $invoiceItems = $get('invoiceItems');
                            $total = 0;

                            foreach ($invoiceItems as $item) {
                                if(Arr::get($item, 'price')) {
                                    $total += Arr::get($item, 'price');
                                }
                            }

                            $vatTotal = $total * (7/100);

                            return $total + $vatTotal;
                        }),
                    TextInput::make('courier_document')->label(__('trans.courier_document.text'))->required(),
                    TextInput::make('recipient_document')->label(__('trans.recipient_document.text'))->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('job_number')->label(__('trans.job_number.text'))->searchable(),
                TextColumn::make('customer')->label(__('trans.customer.text')),
                TextColumn::make('invoice_number')->label(__('trans.invoice_number.text')),
                TextColumn::make('good_code')->label(__('trans.good_code.text')),
                TextColumn::make('vehicle_registration')->label(__('trans.vehicle_registration.text'))->searchable(),
                TextColumn::make('code_c0_c7')->label(__('trans.code_c0_c7.text')),
                TextColumn::make('price')->label(__('trans.price.text')),
                TextColumn::make('spare_code')->label(__('trans.spare_code.text')),
                TextColumn::make('amount')->label(__('trans.amount.text')),
                TextColumn::make('vat')->label(__('trans.vat.text')),
                TextColumn::make('aggregate')->label(__('trans.aggregate.text')),
                TextColumn::make('courier_document')->label(__('trans.courier_document.text')),
                TextColumn::make('recipient_document')->label(__('trans.recipient_document.text')),
            ])
            ->filters([
                Tables\Filters\Filter::make('created_at')
                ->form([
                    Forms\Components\DatePicker::make('created_from')
                        ->placeholder(fn ($state): string => 'Dec 18, ' . now()->subYear()->format('Y')),
                    Forms\Components\DatePicker::make('created_until')
                        ->placeholder(fn ($state): string => now()->format('M d, Y')),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['created_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                        )
                        ->when(
                            $data['created_until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                        );
                })
                ->indicateUsing(function (array $data): array {
                    $indicators = [];
                    if ($data['created_from'] ?? null) {
                        $indicators['created_from'] = 'Order from ' . Carbon::parse($data['created_from'])->toFormattedDateString();
                    }
                    if ($data['created_until'] ?? null) {
                        $indicators['created_until'] = 'Order until ' . Carbon::parse($data['created_until'])->toFormattedDateString();
                    }

                    return $indicators;
                }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }
}
