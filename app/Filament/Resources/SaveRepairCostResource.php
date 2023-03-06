<?php

namespace App\Filament\Resources;

use App\Filament\Traits\JobNumberTrait;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables;
use App\Models\CarReceive;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Filament\Resources\Form;
use Filament\Resources\Table;
use App\Models\SaveRepairCost;
use Filament\Facades\Filament;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SaveRepairCostResource\Pages;
use App\Filament\Resources\SaveRepairCostResource\RelationManagers;

class SaveRepairCostResource extends Resource
{
    protected static ?string $model = SaveRepairCost::class;
    protected static ?string $navigationGroup = 'บัญชี';
    protected static ?string $navigationLabel = 'ต้นทุนค่าแรง';
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $pluralLabel = 'ต้นทุนค่าแรง';

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
                        }
                    }
                }),
        ];
    }
    public static function form(Form $form): Form
    {
        return $form

            ->schema([
                Card::make()->schema(static::getViewData()),
                Fieldset::make('ข้อมูลเจ้าของรถ')
                ->schema([
                    TextInput::make('customer')->label(__('trans.customer.text'))->required()->disabled(),
                    TextInput::make('vehicle_registration')->label(__('trans.vehicle_registration.text'))->required()->disabled(),
                    Select::make('brand')->label(__('trans.brand.text'))->required()->disabled()
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
                            TextInput::make('model')->label(__('trans.model.text'))->required()->disabled(),
                            Select::make('car_year')
                                ->label(__('trans.car_year.text'))
                                ->preload()
                                ->required()
                                ->searchable()
                                ->disabled()
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
                            ]),
                    Fieldset::make('ข้อมูลร้านค้า')
                        ->schema([
                            Select::make('store')->label(__('trans.store.text'))
                            ->required()
                            ->preload()
                            ->options([
                                'ร้านA'=>'ร้านA',
                                'ร้านB'=>'ร้านB',
                                'ร้านC'=>'ร้านC',
                                'ร้านD'=>'ร้านD',
                            ]),
                            TextInput::make('address')->label(__('trans.address.text'))
                            ->required(),
                            TextInput::make('taxpayer_number')->label('เลขที่ประจำตัวผู้เสียภาษี')
                            ->required(),
                            TextInput::make('contact_name')->label('ชื่อผู้ติดต่อ')
                            ->required(),
                            TextInput::make('tel_number')->label('เบอร์โทร')
                            ->required()
                        ]),
                Card::make()
                    ->schema([
                        Placeholder::make('รายการค่าใช้จ่าย'),
                        Repeater::make('saveRepairCostItems')
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
                                    ->numeric()
                                    ->reactive()
                                    ->columnSpan([
                                        'md' => 3,
                                    ])
                                    ->required(),
                                TextInput::make('spare_code')
                                    ->label(__('trans.spare_code.text'))
                                    ->columnSpan([
                                        'md' => 3,
                                    ])
                                    ->required(),
                            ])
                        ->defaultItems(count: 1)
                        ->columns([
                            'md' => 8,
                        ]) ->createItemButtonLabel('เพิ่มรายการค่าใช้จ่าย'),

                    ])->columnSpan('full'),
                    TextInput::make('total')
                        ->label(__('trans.total.text'))
                        ->disabled()
                            ->placeholder(function (Closure $get) {
                                $saveRepairCostItems = $get('saveRepairCostItems');
                                $total = 0;

                                foreach ($saveRepairCostItems as $item) {
                                    if(Arr::get($item, 'price')) {
                                        $total += Arr::get($item, 'price');
                                    }
                                }

                                return $total;
                            }),
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
                TextColumn::make('vehicle_registration')->label(__('trans.vehicle_registration.text'))->searchable(),
                TextColumn::make('customer')->label(__('trans.customer.text')),
                TextColumn::make('vehicle_registration')->label(__('trans.vehicle_registration.text')),
                TextColumn::make('brand')->label(__('trans.brand.text')),
                TextColumn::make('model')->label(__('trans.model.text')),
                TextColumn::make('car_year')->label(__('trans.car_year.text')),
                TextColumn::make('total')
                    ->label(__('trans.total.text'))
                    ->alignEnd()
                    ->formatStateUsing(fn (?string $state): string => number_format($state, 2)),
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
                Tables\Actions\DeleteBulkAction::make()->disabled(),
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
            'index' => Pages\ListSaveRepairCosts::route('/'),
            'create' => Pages\CreateSaveRepairCost::route('/create'),
            'edit' => Pages\EditSaveRepairCost::route('/{record}/edit'),
        ];
    }
}
