<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Forms;
use Filament\Tables;
use App\Models\CarReceive;
use Illuminate\Support\Arr;
use Filament\Resources\Form;
use App\Models\PurchaseOrder;
use Filament\Resources\Table;
use Filament\Facades\Filament;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PurchaseOrderResource\Pages;
use App\Filament\Resources\PurchaseOrderResource\RelationManagers;

class PurchaseOrderResource extends Resource
{
    protected static ?string $model = PurchaseOrder::class;
    protected static ?string $navigationGroup = 'บัญชี';
    protected static ?string $navigationLabel = 'ใบคำสั่งซื้อ';
    protected static ?string $navigationIcon = 'heroicon-o-save-as';
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
                            $set('model', $name['model']);
                            $set('car_year', $name['car_year']);
                            $set('customer', $name['customer']);
                            $set('insu_company_name', $name['insu_company_name']);
                            $set('vehicle_registration', $name['vehicle_registration']);
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
                TextInput::make('vehicle_registration')
                ->required()
                ->disabled()
                ->label(__('trans.vehicle_registration.text')),
                TextInput::make('model')
                ->required()
                ->disabled()
                ->label(__('trans.model.text')),
                TextInput::make('car_year')
                ->required()
                ->disabled()
                ->label(__('trans.car_year.text')),
                Select::make('store')->label(__('trans.store.text'))
                    ->required()
                    ->preload()
                    ->options([
                        'ร้านA'=>'ร้านA',
                        'ร้านB'=>'ร้านB',
                        'ร้านC'=>'ร้านC',
                        'ร้านD'=>'ร้านD',
                    ]),
                TextInput::make('parts_list_total')
                ->required()
                ->label(__('trans.parts_list_total.text')),
                Card::make()
                ->schema([
                    Placeholder::make('รายการอะไหล่'),
                    Repeater::make('purchaseorderitems')
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

                            TextInput::make('parts_list')->label(__('trans.parts_list.text'))
                            ->columnSpan([
                                'md' => 3,
                            ])
                            ->required(),
                            TextInput::make('price')
                                ->label(__('trans.price.text'))
                                ->numeric()
                                ->columnSpan([
                                    'md' => 2,
                                ])
                                ->required(),
                            TextInput::make('quantity')
                                ->label(__('trans.quantity.text'))
                                ->numeric()
                                ->reactive()
                                ->columnSpan([
                                    'md' => 1,
                                ])
                                ->required(),
                            TextInput::make('vat')
                                ->label(__('trans.vat.text'))
                                ->numeric()
                                ->reactive()
                                ->columnSpan([
                                    'md' => 2,
                                ])
                                ->required()
                                ->disabled()
                                ->placeholder(function (Closure $get, Closure $set) {
                                    $quantity = $get('quantity') ? $get('quantity') : 1;
                                    $price = $get('price') ? $get('price') : 0;
                                    $total = $price * $quantity;
                                    $totalVat = $total * (7/100);
                                    $result = $totalVat ? number_format($totalVat, 2) : '0.00';
                                    $set('vat', $result);

                                    return $result;
                                }),
                            Hidden::make('vat'),
                            TextInput::make('aggregate_price_tmp')
                                ->label(__('trans.aggregate_price.text'))
                                ->columnSpan([
                                    'md' => 2,
                                ])
                                ->disabled()
                                ->placeholder(function (Closure $get, Closure $set) {
                                    $quantity = $get('quantity') ? $get('quantity') : 1;
                                    $price = $get('price') ? $get('price') : 0;
                                    $total = $price * $quantity;
                                    $vat = $total * (7/100);
                                    $totalPrice = $total + $vat;
                                    $result = $totalPrice ? number_format($totalPrice, 2) : '0.00';
                                    $set('aggregate_price', $result);

                                    return $result;
                                }),
                            Hidden::make('aggregate_price'),
                        ])
                    ->defaultItems(count: 1)
                    ->columns([
                        'md' => 12,
                    ]) ->createItemButtonLabel('เพิ่มรายการอะไหล่'),

                ])->columnSpan('full'),
                TextInput::make('note')
                ->label(__('trans.note.text'))
                ->required(),
                TextInput::make('buyer')
                ->label(__('ผู้สั่งซื้อ'))
                ->required(),
                TextInput::make('approver')
                ->label('ผู้อนุมัติ')
                ->required(),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('job_number')->label(__('trans.job_number.text'))->searchable(),
                TextColumn::make('vehicle_registration')->label(__('trans.vehicle_registration.text'))->searchable(),
                TextColumn::make('model')->label(__('trans.model.text')),
                TextColumn::make('car_year')->label(__('trans.car_year.text')),
                TextColumn::make('store')->label(__('trans.store.text')),
                TextColumn::make('parts_list_total')->label(__('trans.parts_list_total.text')),
                TextColumn::make('vat')->label(__('trans.vat.text')),
                TextColumn::make('aggregate_price')->label(__('trans.aggregate_price.text')),
                TextColumn::make('note')->label(__('trans.note.text')),
                TextColumn::make('buyer')->label(__('ผู้สั่งซื้อ')),
                TextColumn::make('approver')->label('ผู้อนุมัติ'),
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
                Tables\Actions\DeleteAction::make()->disabled(Filament::auth()->user()->email !== 'super@admin.com'),
            ])
            ->bulkActions([

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
            'index' => Pages\ListPurchaseOrders::route('/'),
            'create' => Pages\CreatePurchaseOrder::route('/create'),
            'edit' => Pages\EditPurchaseOrder::route('/{record}/edit'),
        ];
    }
    public static function canDelete(Model $record): bool
    {
        return Filament::auth()->user()->email === 'super@admin.com';
    }
}
