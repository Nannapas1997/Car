<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\CarReceive;
use App\Models\CarRelease;
use Illuminate\Support\Arr;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CarReleaseResource\Pages;
use App\Filament\Resources\CarReleaseResource\RelationManagers;

class CarReleaseResource extends Resource
{
    protected static ?string $model = CarRelease::class;
    protected static ?string $navigationGroup = 'Account';
    protected static ?string $navigationIcon = 'heroicon-o-arrows-expand';
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
            $jobNumberFirst = $currentGarage . now()->format('-y-m-d-') . '00001';
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
                            $set('choose_garage', $name['choose_garage']);
                            $set('policy_number', $name['policy_number']);
                            $set('vehicle_registration', $name['vehicle_registration']);
                            $set('insu_company_name', $name['insu_company_name']);
                            $set('claim_number', $name['claim_number']);
                            $set('brand', $name['brand']);
                        }
                    }
                }),
        ];
    }
    public static function OCData(): array{
        $optionValue = [];
        $optionData = array('OC' . now()->format('-y-m-d-') . '00001');
        if (!$optionData) {
            $jobNumberFirst = 'OC' . now()->format('-y-m-d-') . '00001';
            $optionData[$jobNumberFirst] = $jobNumberFirst;
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

                $lastValue = 'OC' . now()->format('-y-m-d-') . $lastValue;
                $optionValue[$lastValue] = $lastValue;
            }

            foreach ($optionData as $val) {
                $optionValue[$val] = $val;
            }
        }

        return [
            Select::make('oc_number')
                ->label(__('trans.oc_number.text'))
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
                Card::make()->schema(static::OCData('oc_number')),
                TextInput::make('staff_name')->label('ชื่อ (ข้าพเจ้า)'),
                TextInput::make('staff_position')->label('ตำแหน่งที่เกี่ยวข้องกับ บจ./หจก.'),
                Select::make('brand')->label(__('trans.brand.text'))->required()
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
                TextInput::make('vehicle_registration')->label('เลขทะเบียนรถ'),
                TextInput::make('choose_garage')->label('จากบริษัท (SP / SBO)')
                ->default(Filament::auth()->user()->garage)
                ->disabled(),
                Select::make('insu_company_name')
                ->label(__('trans.insu_company_name.text'))
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
                TextInput::make('policy_number')->label('เลขกรมธรรม์'),
                TextInput::make('claim_number')->label('เลขเคลม / เลขรับแจ้งที่'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('job_number')->label(__('trans.job_number.text')),
                TextColumn::make('oc_number')->label(__('trans.oc_number.text')),
                TextColumn::make('staff_name')->label(__('ชื่อ (ข้าพเจ้า)')),
                TextColumn::make('staff_position')->label(__('ตำแหน่งที่เกี่ยวข้องกับ บจ./หจก.')),
                TextColumn::make('vehicle_registration')->label(__('trans.vehicle_registration.text')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->disabled(Filament::auth()->user()->email !== 'super@admin.com'),
            ])
            ->bulkActions([
//
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCarReleases::route('/'),
            'create' => Pages\CreateCarRelease::route('/create'),
            'edit' => Pages\EditCarRelease::route('/{record}/edit'),
        ];
    }
    public static function canDelete(Model $record): bool
    {
        return Filament::auth()->user()->email === 'super@admin.com';
    }
}
