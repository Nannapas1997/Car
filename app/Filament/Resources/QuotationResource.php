<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Forms;
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
use Illuminate\Support\Facades\Log;

class QuotationResource extends Resource
{
    protected static ?string $model = Quotation::class;
    protected static ?string $navigationGroup = 'งานของฉัน';
    protected static ?string $navigationLabel = 'ใบเสนอราคา';
    protected static ?string $navigationIcon = 'heroicon-o-document-search';

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
                            $set('brand', $name['brand']);
                            $set('repair_code', $name['repair_code']);
                            $set('car_type', $name['car_type']);
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
                TextInput::make('customer')
                ->required()
                ->label(__('trans.customer.text')),
                Select::make('brand')
                ->required()
                ->label(__('trans.brand.text'))
                ->preload()
                ->options([
                    'Toyota' => 'Toyota',
                    'Honda' => 'Honda',
                    'Nissan' => 'Nissan',
                    'Mitsubishi'=>'Mitsubishi',
                    'Isuzu'=>'Isuzu',
                    'Mazda'=>'Mazda',
                    'Ford'=>'Ford',
                    'Suzuki'=>'Suzuki',
                    'Chevrolet'=>'Chevrolet',
                    'Alfa Romeo'=>'Alfo Romeo',
                    'Aston Martin'=>'Aston Martin',
                    'Audi'=>'Audi',
                    'Bentley'=>'Bentley',
                    'BMW'=>'BMW',
                    'Chery'=>'Chery',
                    'Chrysler'=>'Chrysler',
                    'Citroen'=>'Citroen',
                    'Daewoo'=>'Daewoo',
                    'Daihatsu'=>'Daihatsu',
                    'DFM'=>'DFM',
                    'DFSK'=>'DFSK',
                    'Ferrari'=>'Ferrari',
                    'Fiat'=>'Fiat',
                    'FOMM'=>'FOMM',
                    'Foton'=>'Foton',
                    'Great Wall Motor'=>'Great Wall Motor',
                    'Haval'=>'Haval',
                    'HINO' =>'HINO',
                    'Holden'=>'Holden',
                    'Hummer'=>'Hummer',
                    'Hyundai'=>'Hyundai',
                    'Jaguar'=>'Jaguar',
                    'Jeep'=>'Jeep',
                    'Kia'=>'Kia',
                    'Lamborghini'=>'Lamborghini',
                    'Land Rover'=>'Land Rover',
                    'Lexus'=>'Lexus',
                    'Lotus'=>'Lotus',
                    'Maserati'=>'Maserati',
                    'Maxus'=>'Maxus',
                    'McLaren'=>'McLaren',
                    'Mercedes-Benz'=>'Mercedes-Benz',
                    'MG'=>'MG',
                    'Mini'=>'Mini',
                    'Mitsuoka'=>'Mitsuoka',
                    'Naza'=>'Naza',
                    'Opel'=>'Opel',
                    'ORA'=>'ORA',
                    'Peugeot'=>'Peugeot',
                    'Polarsun'=>'Polarsun',
                    'Porsche'=>'Porsche',
                    'Proton'=>'Proton',
                    'Rolls-Royce'=>'Rolls-Royce',
                    'Rover'=>'Rover',
                    'Saab'=>'Saab',
                    'Seat'=>'Seat',
                    'Skoda'=>'Skoda',
                    'Spyker'=>'Spyker',
                    'Ssangyong'=>'Ssangyong',
                    'Subaru'=>'Subaru',
                    'Tata'=>'Tata',
                    'Thairung'=>'Thairung',
                    'Volkswagen'=>'Volkswagen',
                    'Volvo'=>'Volvo',
                ])->columns(65),
                TextInput::make('model')
                ->required()
                ->label(__('trans.model.text')),
                Select::make('car_year')
                    ->label(__('trans.car_year.text'))
                    ->preload()
                    ->required()
                    ->searchable()
                    ->options(function () {
                        $currentYear = intval(now()->format('Y'));
                        $options = [];

                        while ($currentYear > 1999) {
                            $options[$currentYear] = $currentYear;
                            $currentYear--;
                        }
                        return $options;
                    }
                ),
                TextInput::make('vehicle_registration')
                ->required()
                ->label(__('trans.vehicle_registration.text')),
                Select::make('repair_code')->label(__('trans.repair_code.text'))
                ->required()
                ->options([
                    'A' => 'A',
                    'B' => 'B',
                    'C'=>'C',
                    'D'=>'D'
                ])->columns(5),
                Select::make('car_type')->label(__('trans.car_type.text'))->required()
                ->options([
                'รถหัวลาก 10 ล้อ' => 'รถหัวลาก 10 ล้อ',
                'รถหัวลาก 6 ล้อ' => 'รถหัวลาก 6 ล้อ',
                'รถตู้แห้ง 10 ล้อ' => 'รถตู้แห้ง 10 ล้อ',
                'รถตู้แห้ง 6 ล้อ'=>'รถตู้แห้ง 6 ล้อ',
                'รถตู้แห้ง 4 ล้อใหญ่'=>'รถตู้แห้ง 4 ล้อใหญ่',
                'รถกระบะตู้แห้ง'=>'รถกระบะตู้แห้ง',
                'รถตู้เย็น 10 ล้อ'=>'รถตู้เย็น 10 ล้อ',
                'รถตู้เย็น 6 ล้อ'=>'รถตู้เย็น 6 ล้อ',
                'รถตู้เย็น 4 ล้อใหญ่'=>'รถตู้เย็น 4 ล้อใหญ่',
                'รถบรรทุกกระบะคอกสูง 10 ล้อ'=>'รถบรรทุกกระบะคอกสูง 10 ล้อ',
                'รถบรรทุกกระบะคอกสูง 6 ล้อ'=>'รถบรรทุกกระบะคอกสูง 6 ล้อ',
                'รถบรรทุกกระบะคอกเตี้ย 10 ล้อ'=>'รถบรรทุกกระบะคอกเตี้ย 10 ล้อ',
                'รถบรรทุกกระบะคอกเตี้ย 6 ล้อ'=>'รถบรรทุกกระบะคอกเตี้ย 6 ล้อ',
                'รถหางพ่วง'=>'รถหางพ่วง',
                'รถหางพ่วง ตู้แห้ง'=>'รถหางพ่วง ตู้แห้ง',
                'รถหางพ่วง พื้นเรียบ'=>'รถหางพ่วง พื้นเรียบ',
                'รถหางเทรนเลอร์ '=>'รถหางเทรนเลอร์',
                'รถหางเทรนเลอร์ ผ้าใบ'=>'รถหางเทรนเลอร์ ผ้าใบ',
                'รถกระบะ 4 ประตู'=>'รถกระบะ 4 ประตู',
                'รถกระบะแคป'=>'รถกระบะแคป',
                'รถกระบะตอนเดียว'=>'รถกระบะตอนเดียว',
                'รถเก๋ง 4 ประตู'=>'รถเก๋ง 4 ประตู',
                'รถตู้'=>'รถตู้',
                'รถสามล้อ'=>'รถสามล้อ',
                ])->columns(25),
                TextInput::make('sum_insured')
                ->required()
                ->label(__('trans.sum_insured.text')),
                DatePicker::make('creation_date')
                ->required()
                ->label(__('trans.creation_date.text')),
                TextInput::make('claim_number')
                ->required()
                ->label(__('trans.claim_number.text')),
                TextInput::make('accident_number')
                ->required()
                ->label(__('trans.accident_number.text')),
                Select::make('insu_company_name')
                ->label(__('trans.insu_company_name.text'))
                ->required()
                ->preload()
                ->options([
                    'กรุงเทพประกันภัย' => 'กรุงเทพประกันภัย',
                    'กรุงไทยพานิชประกันภัย' => 'กรุงไทยพานิชประกันภัย',
                    'คุ้มภัยโตเกียวมารีน' => 'คุ้มภัยโตเกียวมารีน',
                    'เคเอสเค ประกันภัย' => 'เคเอสเค ประกันภัย',
                    'เจมาร์ท ประกันภัย' => 'เจมาร์ท ประกันภัย',
                    'ชับบ์สามัคคีประกันภัย' => 'ชับบ์สามัคคีประกันภัย',
                    'ทิพยประกันภัย' => 'ทิพยประกันภัย',
                    'เทเวศประกันภัย' => 'เทเวศประกันภัย',
                    'ไทยไพบูลย์' => 'ไทยไพบูลย์',
                    'ไทยวิวัฒน์' => 'ไทยวิวัฒน์',
                    'ไทยศรี' => 'ไทยศรี',
                    'ไทยเศรษฐฯ' => 'ไทยเศรษฐฯ',
                    'นวกิจประกันภัย' => 'นวกิจประกันภัย',
                    'บริษัทกลางฯ' => 'บริษัทกลางฯ',
                    'แปซิฟิค ครอส' => 'แปซิฟิค ครอส',
                    'เมืองไทยประกันภัย' => 'เมืองไทยประกันภัย',
                    'วิริยะประกันภัย' => 'วิริยะประกันภัย',
                    'สินมั่นคง' => 'สินมั่นคง',
                    'อลิอันซ์ อยุธยา' => 'อลิอันซ์ อยุธยา',
                    'อินทรประกันภัย' => 'อินทรประกันภัย',
                    'เอ็ทน่า' => 'เอ็ทน่า',
                    'เอ็มเอสไอจี' => 'เอ็มเอสไอจี',
                    'แอกซ่าประกันภัย' => 'แอกซ่าประกันภัย',
                    'แอลเอ็มจี ประกันภัย' => 'แอลเอ็มจี ประกันภัย',
                ]),
                DatePicker::make('accident_date')
                ->required()
                ->label(__('trans.accident_date.text')),
                DatePicker::make('repair_date')
                ->required()
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
                                Forms\Components\Hidden::make('order_hidden')
                                    ->disabled(true),
                                Select::make('spare_code')
                                    ->label(__('trans.code_c0_c7.text'))
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
                                    ->afterStateUpdated(function ($state, Closure $set) {
                                        $set('order_hidden', $state);
                                    })
                                    ->columnSpan([
                                        'md' => 3,
                                    ]),

                                TextInput::make('list_damaged_parts')
                                    ->label(__('trans.list_damaged_parts.text'))
                                    ->columnSpan([
                                        'md' => 3,
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
                        ]) ->createItemButtonLabel('เพิ่มรายการอะไหล่ที่เสียหาย'),

                    ])->columnSpan('full'),
                    TextInput::make('overall_price')
                        ->label(__('trans.overall_price.text'))
                        ->disabled()
                        ->placeholder(function (Closure $get) {
                            return count($get('quotationitems')) . ' รายการ';
                        }),
                TextInput::make('wage')
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

                        return $total ? number_format($total, 2) : '0.00';
                    }),
                    TextInput::make('including_spare_parts')
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

                            return $total ? number_format($total, 2) : '0.00';
                        }),
                    Radio::make('choose_vat_or_not_1')
                    ->columnSpanFull()
                    ->label('ระบุตัวเลือกที่ต้องการ')
                    ->required()
                    ->options([
                        'รวมvat'=>'รวมvat 7%',
                        'ไม่รวมvat'=>'ไม่รวมvat 7%',
                    ]),
                    TextInput::make('vat')
                        ->label(__('trans.vat.text'))
                        ->disabled()
                        ->placeholder(function (Closure $get) {
                            $items = $get('quotationitems');
                            $total = 0;

                            foreach ($items as $item) {
                                $quantity = Arr::get($item, 'quantity', 1);

                                if (Arr::get($item, 'spare_code') == 'C6') {
                                    $quantity = 1;
                                }

                                if(
                                    Arr::get($item, 'spare_code')
                                ) {
                                    $total += Arr::get($item, 'price') * $quantity;
                                }
                            }

                            $vatTotal = $total * (7/100);

                            return $vatTotal ? number_format($vatTotal, 2) : '0.00';
                        }),
                    TextInput::make('overall')
                        ->label(__('trans.overall.text'))
                        ->disabled()
                        ->placeholder(function (Closure $get) {
                            $items = $get('quotationitems');
                            $total = 0;

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

                            $vatTotal = $total * (7/100);
                            $sumTotal = $vatTotal + $total;

                            return $sumTotal ? number_format($sumTotal, 2) : '0.00';
                        }),
                        TextInput::make('sks')
                        ->required()
                        ->label(__('trans.sks.text')),
                        TextInput::make('wchp')
                        ->required()
                        ->label(__('trans.wchp.text')),
                        Select::make('price_control_officer')->label(__('trans.price_control_officer.text'))
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
                TextInput::make('wage')
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

                        return $total ? number_format($total, 2) : '0.00';
                    }),
                    TextInput::make('including_spare_parts')
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

                            return $total ? number_format($total, 2) : '0.00';
                        }),
                    Radio::make('choose_vat_or_not_2')
                    ->columnSpanFull()
                    ->label('ระบุตัวเลือกที่ต้องการ')
                    ->required()
                    ->options([
                        'รวมvat'=>'รวมvat 7%',
                        'ไม่รวมvat'=>'ไม่รวมvat 7%',
                    ]),
                    TextInput::make('vat')
                        ->label(__('trans.vat.text'))
                        ->disabled()
                        ->placeholder(function (Closure $get) {
                            $items = $get('quotationitems');
                            $total = 0;

                            foreach ($items as $item) {
                                $quantity = Arr::get($item, 'quantity', 1);

                                if (Arr::get($item, 'spare_code') == 'C6') {
                                    $quantity = 1;
                                }

                                if(
                                    Arr::get($item, 'spare_code')
                                ) {
                                    $total += Arr::get($item, 'price') * $quantity;
                                }
                            }

                            $vatTotal = $total * (7/100);

                            return $vatTotal ? number_format($vatTotal, 2) : '0.00';
                        }),
                    TextInput::make('overall')
                        ->label(__('trans.overall.text'))
                        ->disabled()
                        ->placeholder(function (Closure $get) {
                            $items = $get('quotationitems');
                            $total = 0;

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

                            $vatTotal = $total * (7/100);
                            $sumTotal = $vatTotal + $total;

                            return $sumTotal ? number_format($sumTotal, 2) : '0.00';
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
                TextColumn::make('creation_date')->label(__('trans.creation_date.text'))->searchable(),
                TextColumn::make('claim_number')->label(__('trans.claim_number.text')),
                TextColumn::make('accident_number')->label(__('trans.accident_number.text')),
                TextColumn::make('insu_company_name')->label(__('trans.insu_company_name.text')),
                TextColumn::make('accident_date')->label(__('trans.accident_date.text')),
                TextColumn::make('repair_date')->label(__('trans.repair_date.text')),
                TextColumn::make('quotation_date')->label(__('trans.quotation_date.text'))->searchable(),
                TextColumn::make('store')->label(__('trans.store.text')),
                TextColumn::make('wage')->label(__('trans.wage.text')),
                TextColumn::make('including_spare_parts')->label(__('trans.including_spare_parts.text')),
                TextColumn::make('total_wage')->label(__('trans.total_wage.text')),
                TextColumn::make('vat')->label(__('trans.vat.text')),
                TextColumn::make('overall')->label(__('trans.overall.text')),
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
