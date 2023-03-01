<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Forms;
use App\Models\Bill;
use Filament\Tables;
use App\Models\CarReceive;
use Illuminate\Support\Arr;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Facades\Filament;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\BillResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BillResource\RelationManagers;

class BillResource extends Resource
{
    protected static ?string $model = Bill::class;
    protected static ?string $navigationGroup = 'บัญชี';
    protected static ?string $navigationLabel = 'ใบวางบิลsssss';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
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
                TextInput::make('customer')->label(__('trans.customer.text'))->required()->disabled(),
                TextInput::make('vehicle_registration')->label(__('trans.vehicle_registration.text'))->required()->disabled(),
                TextInput::make('invoice_number')->label(__('trans.invoice_number.text'))->required(),
                TextInput::make('bill_number')->label(__('trans.bill_number.text'))->required(),
                TextInput::make('amount')
                    ->label(__('trans.amount.text'))
                    ->numeric()
                    ->reactive()
                    ->required(),
                Radio::make('choose_vat_or_not')
                    ->columnSpanFull()
                    ->label('ระบุตัวเลือกที่ต้องการ')
                    ->reactive()
                    ->required()
                    ->options([
                        'vat_include_yes'=>'รวมvat 7%',
                        'vat_include_no'=>'ไม่รวมvat 7%',
                ]),
                TextInput::make('vat_display')
                    ->label(__('trans.vat.text'))
                    ->disabled()
                    ->placeholder(function (Closure $get) {
                        $chooseVat = $get('choose_vat_or_not');
                        $result = 0;
                        $vat = 0;
                        $amount = $get('amount') ? $get('amount') : 0;

                        if ($chooseVat == 'vat_include_yes') {
                            $vat = $amount * (7/100);
                        }

                        return $vat ? number_format($vat, 2) : '0.00';
                    }),
                TextInput::make('aggregate_display')
                    ->label(__('trans.aggregate.text'))
                    ->disabled()
                    ->placeholder(function (Closure $get) {
                        $amount = $get('amount') ? $get('amount') : 0;
                        $chooseVat = $get('choose_vat_or_not');
                        $vat = 0;
                        $total = 0;

                        if ($chooseVat == 'vat_include_yes') {
                            $vat = $amount * (7/100);
                        }

                        $total = $amount + $vat;

                        return $total ? number_format($total, 2) : '0.00';
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
                TextColumn::make('vehicle_registration')->label(__('trans.vehicle_registration.text'))->searchable(),
                TextColumn::make('invoice_number')->label(__('trans.invoice_number.text')),
                TextColumn::make('bill_number')->label(__('trans.bill_number.text')),
                TextColumn::make('amount')->label(__('trans.amount.text')),
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

            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBills::route('/'),
            'create' => Pages\CreateBill::route('/create'),
            'edit' => Pages\EditBill::route('/{record}/edit'),
        ];
    }
    public static function canDelete(Model $record): bool
    {
        return Filament::auth()->user()->email === 'super@admin.com';
    }
}
