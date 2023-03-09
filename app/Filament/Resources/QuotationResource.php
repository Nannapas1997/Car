<?php

namespace App\Filament\Resources;

use App\Filament\Traits\JobNumberTrait;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables;
use App\Models\Quotation;
use App\Models\CarReceive;
use Illuminate\Support\Arr;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Facades\Filament;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use App\Filament\Resources\QuotationResource\Pages;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class QuotationResource extends Resource
{
    use JobNumberTrait;

    protected static ?string $model = Quotation::class;
    protected static ?string $navigationGroup = 'งานของฉัน';
    protected static ?string $navigationLabel = 'ใบเสนอราคา';
    protected static ?string $navigationIcon = 'heroicon-o-document-search';
    protected static ?string $pluralLabel = 'ใบเสนอราคา';

    public static function form(Form $form): Form
    {
        $currentGarage =  Filament::auth()->user()->garage;

        return $form
            ->schema([
                Hidden::make('choose_garage')->default($currentGarage),
                DatePicker::make('creation_date')
                    ->required()
                    ->disabled()
                    ->default(now()->format('Y-m-d'))
                    ->label(__('trans.creation_date.text')),
                Card::make()->schema(
                    static::getViewData($currentGarage, function ($set, $state) use ($currentGarage) {
                        if ($state) {
                            $carReceive = CarReceive::query()->where('job_number', $state)->first();

                            if ($carReceive) {
                                $carReceive = $carReceive->toArray();
                                $set('model', $carReceive['model']);
                                $set('car_year', $carReceive['car_year']);
                                $set('customer', $carReceive['customer']);
                                $set('insu_company_name', $carReceive['insu_company_name']);
                                $set('vehicle_registration', $carReceive['vehicle_registration']);
                                $set('brand', $carReceive['brand']);
                                $set('repair_code', $carReceive['repair_code']);
                                $set('car_type', $carReceive['car_type']);
                                $set('sum_insured', $carReceive['sum_insured']);
                                $set('number_ab', $carReceive['number_ab']);
                                $set('accident_date', $carReceive['accident_date']);
                                $set('repair_date', $carReceive['repair_date']);
                                $set('claim_number', $carReceive['claim_number']);
                            }
                        }
                    })
                ),
                TextInput::make('customer')
                    ->required()
                    ->disabled()
                    ->label(__('trans.customer.text')),
                Select::make('brand')
                    ->disabled()
                    ->required()
                    ->label(__('trans.brand.text'))
                    ->preload()
                    ->options(Config::get('static.car-brand'))
                    ->columns(65),
                TextInput::make('model')
                    ->required()
                    ->label(__('trans.model.text')),
                Select::make('car_year')
                    ->label(__('trans.car_year.text'))
                    ->preload()
                    ->required()
                    ->disabled()
                    ->searchable()
                    ->options(helperGetYearList()),
                TextInput::make('vehicle_registration')
                    ->required()
                    ->disabled()
                    ->label(__('trans.vehicle_registration.text')),
                Select::make('repair_code')
                    ->label(__('trans.repair_code.text'))
                    ->required()
                    ->disabled()
                    ->options(Config::get('static.repair-code'))
                    ->columns(5),
                Select::make('car_type')
                    ->label(__('trans.car_type.text'))
                    ->required()
                    ->options(Config::get('static.car-type'))
                    ->columns(25)
                    ->disabled(),
                TextInput::make('sum_insured')
                    ->required()
                    ->label(__('trans.sum_insured.text'))
                    ->disabled(),
                TextInput::make('claim_number')
                    ->required()
                    ->disabled()
                    ->label(__('trans.claim_number.text')),
                TextInput::make('number_ab')
                    ->required()
                    ->disabled()
                    ->label(__('trans.number_ab.text')),
                Select::make('insu_company_name')
                    ->label(__('trans.insu_company_name.text'))
                    ->required()
                    ->disabled()
                    ->preload()
                    ->options(Config::get('static.insu-company')),
                DatePicker::make('accident_date')
                    ->required()
                    ->disabled()
                    ->label(__('trans.accident_date.text')),
                DatePicker::make('repair_date')
                    ->required()
                    ->disabled()
                    ->label(__('trans.repair_date.text')),
                DatePicker::make('quotation_date')
                    ->required()
                    ->label(__('trans.quotation_date.text'))
                    ->default(now()->format('Y-m-d'))
                    ->disabled(),
                Card::make()
                    ->schema([
                        Placeholder::make('รายการอะไหล่ที่เสียหาย'),
                        Repeater::make('quotationitems')
                            ->reactive()
                            ->relationship()
                            ->schema(
                                [
                                    Hidden::make('order_hidden')->disabled(true),
                                    Select::make('spare_code')
                                        ->label(__('trans.code_c0_c7.text'))
                                        ->options(Config::get('static.code-c0-c7'))
                                        ->required()
                                        ->reactive()
                                        ->afterStateUpdated(function ($state, Closure $set) {
                                            $set('order_hidden', $state);
                                        })
                                        ->columnSpan([
                                            'md' => 2,
                                        ]),

                                    TextInput::make('list_damaged_parts')
                                        ->label(__('trans.list_damaged_parts.text'))
                                        ->columnSpan([
                                            'md' => 5,
                                        ])
                                        ->hidden(fn (Closure $get) => $get('spare_code') == 'C6'),
                                    TextInput::make('quantity')
                                        ->label(__('trans.quantity.text'))
                                        ->numeric()
                                        ->default(1)
                                        ->columnSpan([
                                            'md' => 2,
                                        ])
                                        ->hidden(fn (Closure $get) => $get('spare_code') == 'C6'),
                                    TextInput::make('price')
                                        ->numeric()
                                        ->reactive()
                                        ->label(function (Closure $get) {
                                            if ($get('spare_code') == 'C6') {
                                                return 'ค่าแรง';
                                            }
                                            return __('trans.spare_value.text');
                                        })
                                        ->columnSpan([
                                            'md' => 3,
                                        ])
                                        ->required(),
                                ])
                            ->defaultItems(count: 1)
                            ->columns([
                                'md' => 12,
                            ])
                            ->createItemButtonLabel('เพิ่มรายการอะไหล่ที่เสียหาย'),

                    ])
                    ->columnSpan('full'),
                TextInput::make('overall_price')
                    ->label(__('trans.overall_price.text'))
                    ->disabled()
                    ->placeholder(function (Closure $get) {
                        return count($get('quotationitems')) . ' รายการ';
                    }),
                TextInput::make('wage_display')
                    ->label(__('trans.wage.text'))
                    ->disabled()
                    ->placeholder(function (Closure $get) {
                        return calTotalWageItems($get('quotationitems'), 'price', 'vat_include_no');
                    }),
                TextInput::make('including_spare_parts_display')
                    ->label(__('trans.including_spare_parts.text'))
                    ->disabled()
                    ->placeholder(function (Closure $get) {
                        return calTotalExcludeWageItems($get('quotationitems'), 'price', 'vat_include_no');
                    }),
                Radio::make('choose_vat_or_not_1')
                    ->columnSpanFull()
                    ->label('ระบุตัวเลือกที่ต้องการ')
                    ->reactive()
                    ->required()
                    ->options(Config::get('static.include-vat-options'))
                    ->default('vat_include_yes'),
                TextInput::make('vat_display')
                    ->label(__('trans.vat.text'))
                    ->disabled()
                    ->placeholder(function (Closure $get) {
                        $items = $get('quotationitems');
                        $chooseVat = $get('choose_vat_or_not_1');
                        $total = 0;
                        $vatTotal = 0;

                        foreach ($items as $item) {
                            $quantity = Arr::get($item, 'quantity', 1);

                            if (Arr::get($item, 'spare_code') == 'C6') {
                                $quantity = 1;
                            }

                            if(
                                Arr::get($item, 'price')
                            ) {
                                $total += Arr::get($item, 'price') * $quantity;
                            }

                        }
                        if ($chooseVat == 'vat_include_yes') {
                            $vatTotal = $total * (7/100);
                        }

                        return $vatTotal ? number_format(str_replace(',', '', $vatTotal), 2) : '0.00';
                    }),
                TextInput::make('overall_display')
                    ->label(__('trans.overall.text'))
                    ->disabled()
                    ->placeholder(function (Closure $get) {
                        $items = $get('quotationitems');
                        $chooseVat = $get('choose_vat_or_not_1');
                        $total = 0;
                        $vatTotal = 0;

                        foreach ($items as $item) {
                            $quantity = Arr::get($item, 'quantity', 1);

                            if (Arr::get($item, 'spare_code') == 'C6') {
                                $quantity = 1;
                            }

                            if(
                                Arr::get($item, 'price')
                            ) {
                                $total += Arr::get($item, 'price') * $quantity;
                            }
                        }

                        if ($chooseVat == 'vat_include_yes') {
                            $vatTotal = $total * (7/100);
                        }
                        $sumTotal = $vatTotal + $total;

                        return $sumTotal ? number_format(str_replace(',', '', $sumTotal), 2) : '0.00';
                    }),
                    TextInput::make('sks')
                        ->required()
                        ->label(__('trans.sks.text')),
                    TextInput::make('wchp')
                        ->required()
                        ->label(__('trans.wchp.text')),
                    Select::make('price_control_officer')
                        ->label(__('trans.price_control_officer.text'))
                        ->required()
                        ->preload()
                        ->options([
                            'ติณณภพ สุขจิต'=>'ติณณภพ สุขจิต',
                            'อัจฉรียสา เขษมบุษป์'=>'อัจฉรียสา เขษมบุษป์',
                            'อัคคัญญ์ กิตติ์จีระภูมิ '=>'อัคคัญญ์ กิตติ์จีระภูมิ',
                            'ธนพฤทธ์ เถกิงศักดิ์'=>'ธนพฤทธ์ เถกิงศักดิ์',
                        ]),
                    TextInput::make('overall_price')
                        ->label(__('trans.overall_price.text'))
                        ->disabled()
                        ->placeholder(function (Closure $get) {
                            return count($get('quotationitems')) . ' รายการ';
                        }),
                    TextInput::make('wage_display_1')
                        ->label(__('trans.wage.text'))
                        ->disabled()
                        ->placeholder(function (Closure $get) {
                            $items = $get('quotationitems');
                            $total = 0;

                            foreach ($items as $item) {
                                if(Arr::get($item, 'price') && Arr::get($item, 'spare_code') == 'C6') {
                                    $total += Arr::get($item, 'price');
                                }
                            }

                            return $total ? number_format(str_replace(',', '', $total), 2) : '0.00';
                        }),
                    TextInput::make('including_spare_parts_1')
                        ->label(__('trans.including_spare_parts.text'))
                        ->disabled()
                        ->placeholder(function (Closure $get) {
                            $items = $get('quotationitems');
                            $total = 0;

                            foreach ($items as $item) {
                                $quantity = Arr::get($item, 'quantity', 1);

                                if(
                                    Arr::get($item, 'price') &&
                                    Arr::get($item, 'spare_code') != 'C6'
                                ) {
                                    $total += Arr::get($item, 'price') * $quantity;
                                }
                            }

                            return $total ? number_format(str_replace(',', '', $total), 2) : '0.00';
                        }),
                    Radio::make('choose_vat_or_not')
                        ->columnSpanFull()
                        ->label('ระบุตัวเลือกที่ต้องการ')
                        ->reactive()
                        ->required()
                        ->options(Config::get('static.include-vat-options'))
                        ->default('vat_include_yes'),
                    TextInput::make('vat_display_1')
                        ->label(__('trans.vat.text'))
                        ->disabled()
                        ->placeholder(function (Closure $get) {
                            $items = $get('quotationitems');
                            $chooseVat = $get('choose_vat_or_not');
                            $total = 0;
                            $vatTotal = 0;
                            foreach ($items as $item) {
                                $quantity = Arr::get($item, 'quantity', 1);

                                if (Arr::get($item, 'spare_code') == 'C6') {
                                    $quantity = 1;
                                }

                                if(
                                    Arr::get($item, 'price')
                                ) {
                                    $total += Arr::get($item, 'price') * $quantity;
                                }
                            }
                            if ($chooseVat == 'vat_include_yes') {
                                $vatTotal = $total * (7/100);
                            }


                            return $vatTotal ? number_format(str_replace(',', '', $vatTotal), 2) : '0.00';
                        }),
                    TextInput::make('overall_1')
                        ->label(__('trans.overall.text'))
                        ->disabled()
                        ->placeholder(function (Closure $get) {
                            $items = $get('quotationitems');
                            $chooseVat = $get('choose_vat_or_not');
                            $total = 0;
                            $vatTotal = 0;

                            foreach ($items as $item) {
                                $quantity = Arr::get($item, 'quantity', 1);

                                if (Arr::get($item, 'spare_code') == 'C6') {
                                    $quantity = 1;
                                }

                                if(
                                    Arr::get($item, 'price')
                                ) {
                                    $total += Arr::get($item, 'price') * $quantity;
                                }
                            }
                            if ($chooseVat == 'vat_include_yes') {
                                $vatTotal = $total * (7/100);
                            }

                            $sumTotal = $vatTotal + $total;

                            return $sumTotal ? number_format(str_replace(',', '', $sumTotal), 2) : '0.00';
                        }),
                    Fieldset::make('สถานะการจัดการใบเสนอราคา')
                        ->schema([
                            Radio::make('status')
                            ->label(__('trans.status.text'))
                            ->required()
                            ->options([
                                'รออนุมัติ' => 'รออนุมัติ',
                                'กำลังดำเนินการ' => 'กำลังดำเนินการ',
                                'เสร็จสิ้น' => 'เสร็จสิ้น',
                            ])
                        ]),
                    SpatieMediaLibraryFileUpload::make('other_files')
                        ->multiple()
                        ->label(__('trans.other_files.text'))
                        ->image()
                        ->enableDownload(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('job_number')->label(__('trans.job_number.text'))->searchable(),
                TextColumn::make('customer')->label(__('trans.customer.text')),
                TextColumn::make('brand')->label(__('trans.brand.text')),
                TextColumn::make('model')->label(__('trans.model.text')),
                TextColumn::make('car_year')->label(__('trans.car_year.text')),
                TextColumn::make('vehicle_registration')->label(__('trans.vehicle_registration.text'))->searchable(),
                TextColumn::make('repair_code')->label(__('trans.repair_code.text')),
                TextColumn::make('car_type')->label(__('trans.car_type.text')),
                TextColumn::make('sum_insured')->label(__('trans.sum_insured.text')),
                TextColumn::make('creation_date')
                    ->label(__('trans.creation_date.text'))
                    ->searchable()
                    ->formatStateUsing(fn (?string $state): string => convertYmdToThaiShort($state)),
                TextColumn::make('claim_number')->label(__('trans.claim_number.text')),
                TextColumn::make('number_ab')->label(__('trans.number_ab.text')),
                TextColumn::make('insu_company_name')->label(__('trans.insu_company_name.text')),
                TextColumn::make('accident_date')
                    ->label(__('trans.accident_date.text'))
                    ->formatStateUsing(fn (?string $state): string => convertYmdToThaiShort($state)),
                TextColumn::make('repair_date')
                    ->label(__('trans.repair_date.text'))
                    ->formatStateUsing(fn (?string $state): string => convertYmdToThaiShort($state)),
                TextColumn::make('quotation_date')
                    ->label(__('trans.quotation_date.text'))
                    ->searchable()
                    ->formatStateUsing(fn (?string $state): string => convertYmdToThaiShort($state)),


                BadgeColumn::make('status')
                    ->label(__('trans.status.text'))
                    ->colors([
                        'danger' => 'รออนุมัติ',
                        'warning' => 'กำลังดำเนินการ',
                        'success' => 'เสร็จสิ้น',
                    ]),
                TextColumn::make('sks')->label(__('trans.sks.text')),
                TextColumn::make('wchp')->label(__('trans.wchp.text')),
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
                Tables\Actions\DeleteAction::make()
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
            'index' => Pages\ListQuotations::route('/'),
            'create' => Pages\CreateQuotation::route('/create'),
            'edit' => Pages\EditQuotation::route('/{record}/edit'),
        ];
    }
}
