<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Forms;
use Filament\Tables;
use App\Models\Invoice;
use App\Models\CarReceive;
use App\Models\CarRelease;
use Illuminate\Support\Arr;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Facades\Filament;
use Illuminate\Support\Carbon;
use PhpParser\Node\Stmt\Label;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use App\Filament\Resources\InvoiceResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\InvoiceResource\RelationManagers;
use Filament\Forms\Components\ViewField;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;
    protected static ?string $navigationGroup = 'บัญชี';
    protected static ?string $navigationLabel = 'ใบแจ้งหนี้';
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
                            $set('brand', $name['brand']);
                            $set('insu_company_name', $name['insu_company_name']);
                        }
                    }
                }),
        ];
    }
    public static function getINVdata(): array{
        $currentGarage =  Filament::auth()->user()->garage;
        $optionData = Invoice::query()
            ->where('choose_garage', $currentGarage)
            ->orderBy('INV_number', 'desc')
            ->get('INV_number')
            ->pluck('INV_number', 'INV_number')
            ->toArray();
        $optionValue = [];

        if (!$optionData) {
            $INVFirst = 'INV' . now()->format('-y-m-d-') . '00001';
            $optionValue[$INVFirst] = $INVFirst;
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

                $lastValue = 'INV' . now()->format('-y-m-d-') . $lastValue;
                $optionValue[$lastValue] = $lastValue;
            }

            foreach ($optionData as $val) {
                $optionValue[$val] = $val;
            }
        }

        return[
            Select::make('INV_number')
            ->label(__('trans.INV_number.text'))
            ->preload()
            ->required()
            ->searchable()
            ->options($optionValue)
        ];
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema(static::getViewData('job_number')),
                Card::make()->schema(static::getINVdata('INV_number')),
                TextInput::make('customer')->label(__('trans.customer.text'))
                ->required()
                ->disabled(),
                Select::make('insu_company_name')
                    ->label(__('trans.insu_company_name.text'))
                    ->preload()
                    ->required()
                    ->disabled()
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
                Select::make('brand')->label(__('trans.brand.text'))
                    ->required()
                    ->disabled()
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
                TextInput::make('vehicle_registration')
                    ->label(__('trans.vehicle_registration.text'))
                    ->required()
                    ->disabled(),
                Card::make()
                    ->schema([
                        Placeholder::make('รายการค่าใช้จ่าย'),
                        Repeater::make('invoiceItems')
                            ->reactive()
                            ->relationship()
                            ->schema(
                                [
                                    TextInput::make('items')
                                        ->label(__('trans.items.text'))
                                        ->columnSpan([
                                            'md' => 5,
                                        ])
                                        ->required(),
                                    TextInput::make('amount')->label(__('trans.amount.text'))
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
                                if(Arr::get($item, 'amount')) {
                                    $total += Arr::get($item, 'amount');
                                }
                            }

                            return $total ? number_format($total, 2) : '0.00';
                        }),
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
                            $invoiceItems = $get('invoiceItems');
                            $total = 0;
                            $vatTotal = 0;

                            if ($get('choose_vat_or_not') == 'vat_include_yes') {
                                foreach ($invoiceItems as $item) {
                                    if(Arr::get($item, 'price')) {
                                        $total += Arr::get($item, 'price');
                                    }
                                }

                                $vatTotal = $total * (7/100);
                            }



                            return $vatTotal ? number_format($vatTotal, 2) : '0.00';
                        }),
                    TextInput::make('aggregate_display')
                        ->label(__('trans.aggregate.text'))
                        ->disabled()
                        ->placeholder(function (Closure $get) {
                            $invoiceItems = $get('invoiceItems');
                            $total = 0;
                            $vatTotal = 0;

                            foreach ($invoiceItems as $item) {
                                if(Arr::get($item, 'price')) {
                                    $total += Arr::get($item, 'price');
                                }
                            }

                            if ($get('choose_vat_or_not') == 'vat_include_yes') {
                                $vatTotal = $total * (7/100);
                            }

                            return $total + $vatTotal;
                        }),
                    ViewField::make('courier_document')->view('filament.resources.forms.components.sender-document'),
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
                TextColumn::make('vehicle_registration')->label(__('trans.vehicle_registration.text'))->searchable(),
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
