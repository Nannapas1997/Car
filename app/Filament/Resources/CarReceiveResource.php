<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\ViewField;
use Filament\Tables;
use App\Models\CarReceive;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\CarReceiveResource\Pages;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Models\ThailandAddress;

class CarReceiveResource extends Resource
{
    protected static ?string $model = CarReceive::class;
    protected static ?string $navigationGroup = 'งานของฉัน';
    protected static ?string $navigationLabel = 'ใบรับรถ';
    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function getViewData(): array
    {
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
                ->options($optionValue)
                ->reactive()
                ->afterStateUpdated(function ($set, $state) use ($currentGarage) {
                    if ($state) {
                        $name = CarReceive::query()->where('job_number', $state)->first();
                        if ($name) {
                            $name = $name->toArray();
                            $set('choose_garage', $currentGarage);
                            $set('receive_date', $name['receive_date']);
                            $set('timex', $name['timex']);
                            $set('customer', $name['customer']);
                            $set('repairman', $name['repairman']);
                            $set('tel_number', $name['tel_number']);
                            $set('pickup_date', $name['pickup_date']);
                            $set('vehicle_registration', $name['vehicle_registration']);
                            $set('brand', $name['brand']);
                            $set('model', $name['model']);
                            $set('car_type', $name['car_type']);
                            $set('car_year', $name['car_year']);
                            $set('mile_number', $name['mile_number']);
                            $set('repair_code', $name['repair_code']);
                            $set('options', $name['options']);
                            $set('insu_company_name', $name['insu_company_name']);
                            $set('policy_number', $name['policy_number']);
                            $set('noti_number', $name['noti_number']);
                            $set('claim_number', $name['claim_number']);
                            $set('park_type', $name['park_type']);
                            $set('content', $name['content']);
                            $set('car_park', $name['car_park']);
                            $set('spare_tire', $name['spare_tire']);
                            $set('jack_handle', $name['jack_handle']);
                            $set('boxset', $name['boxset']);
                            $set('batteries', $name['batteries']);
                            $set('cigarette_lighter', $name['cigarette_lighter']);
                            $set('radio', $name['radio']);
                            $set('floor_mat', $name['floor_mat']);
                            $set('spare_removal', $name['spare_removal']);
                            $set('fire_extinguisher', $name['fire_extinguisher']);
                            $set('spining_wheel', $name['spining_wheel']);
                            $set('other', $name['other']);
                            $set('real_claim_document', $name['real_claim_document']);
                            $set('copy_claim', $name['copy_claim']);
                            $set('copy_driver_license', $name['copy_driver_license']);
                            $set('copy_vehicle_regis', $name['copy_vehicle_regis']);
                            $set('copy_policy', $name['copy_policy']);
                            $set('power_of_attorney', $name['power_of_attorney']);
                            $set('copy_of_director_id_card', $name['copy_of_director_id_card']);
                            $set('copy_of_person', $name['copy_of_person']);
                            $set('account_book', $name['account_book']);
                            $set('car_accident', $name['car_accident']);
                            $set('car_accident_choose', $name['car_accident_choose']);
                            $set('options-car', $name['options-car']);
                            $set('atm_card', $name['atm_card']);
                            $set('postal_code', $name['postal_code']);
                            $set('district', $name['district']);
                            $set('amphoe', $name['amphoe']);
                            $set('province', $name['province']);
                            $set('driver_tel_number', $name['driver_tel_number']);
                            $set('customer_tel_number', $name['customer_tel_number']);
                            $set('repairman_tel_number', $name['repairman_tel_number']);
                        }
                    }
                }),
        ];
    }
    public static function form(Form $form): Form
    {
        return $form->schema(
            [
                TextInput::make('choose_garage')
                    ->default(Filament::auth()->user()->garage)
                    ->disabled(),
                DatePicker::make('receive_date')->label(__('trans.receive_date.text'))
                ->required()
                ->default(now()->format('Y-m-d'))
                ->disabled(),
                Card::make()->schema(static::getViewData('job_number')),
                Select::make('search_regis')
                    ->label(__('trans.search_regis.text'))
                    ->preload()
                    ->options(CarReceive::all()->pluck('vehicle_registration', 'id')->toArray())
                    ->searchable()
                    ->reactive()
                    ->afterStateUpdated(function ($set, $state) {
                        if ($state) {
                            $name = CarReceive::find($state)->toArray();
                            $currentGarage =  Filament::auth()->user()->garage;
                            if ($name) {
                                $set('choose_garage', $currentGarage);
                                $set('receive_date', $name['receive_date']);
                                $set('timex', $name['timex']);
                                $set('customer', $name['customer']);
                                $set('repairman', $name['repairman']);
                                $set('tel_number', $name['tel_number']);
                                $set('pickup_date', $name['pickup_date']);
                                $set('vehicle_registration', $name['vehicle_registration']);
                                $set('brand', $name['brand']);
                                $set('model', $name['model']);
                                $set('car_type', $name['car_type']);
                                $set('car_year', $name['car_year']);
                                $set('mile_number', $name['mile_number']);
                                $set('repair_code', $name['repair_code']);
                                $set('options', $name['options']);
                                $set('car_accident', $name['car_accident']);
                                $set('car_accident_choose', $name['car_accident_choose']);
                                $set('options-car', $name['options-car']);
                                $set('insu_company_name', $name['insu_company_name']);
                                $set('policy_number', $name['policy_number']);
                                $set('noti_number', $name['noti_number']);
                                $set('claim_number', $name['claim_number']);
                                $set('park_type', $name['park_type']);
                                $set('content', $name['content']);
                                $set('car_park', $name['car_park']);
                                $set('spare_tire', $name['spare_tire']);
                                $set('jack_handle', $name['jack_handle']);
                                $set('boxset', $name['boxset']);
                                $set('batteries', $name['batteries']);
                                $set('cigarette_lighter', $name['cigarette_lighter']);
                                $set('radio', $name['radio']);
                                $set('floor_mat', $name['floor_mat']);
                                $set('spare_removal', $name['spare_removal']);
                                $set('fire_extinguisher', $name['fire_extinguisher']);
                                $set('spining_wheel', $name['spining_wheel']);
                                $set('other', $name['other']);
                                $set('real_claim_document', $name['real_claim_document']);
                                $set('copy_claim', $name['copy_claim']);
                                $set('copy_driver_license', $name['copy_driver_license']);
                                $set('copy_vehicle_regis', $name['copy_vehicle_regis']);
                                $set('copy_policy', $name['copy_policy']);
                                $set('power_of_attorney', $name['power_of_attorney']);
                                $set('copy_of_director_id_card', $name['copy_of_director_id_card']);
                                $set('copy_of_person', $name['copy_of_person']);
                                $set('account_book', $name['account_book']);
                                $set('atm_card', $name['atm_card']);
                                $set('postal_code', $name['postal_code']);
                                $set('district', $name['district']);
                                $set('amphoe', $name['amphoe']);
                                $set('province', $name['province']);
                                $set('driver_tel_number', $name['driver_tel_number']);
                                $set('customer_tel_number', $name['customer_tel_number']);
                                $set('repairman_tel_number', $name['repairman_tel_number']);
                            }
                        }
                    }),
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
                        TextInput::make('model')->label(__('trans.model.text'))->required(),
                        TextInput::make('vehicle_registration')->label(__('trans.vehicle_registration.text'))->required(),
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
                        }),
                        Select::make('car_type')->label(__('trans.car_type.text'))
                    ->required()
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
                        ])
                    ->columns(25),
               Select::make('prefix')
               ->label(__('trans.prefix.text'))->nullable()
               ->searchable()
               ->preload()
               ->reactive()
               ->options([
                'หจก.' => 'หจก.',
                'บจก.' => 'บจก.',
                'นาย' => 'นาย',
                'นาง' => 'นาง',
                'นางสาว' => 'นางสาว'
               ]),
               TextInput::make('customer')->label(__('trans.customer.text'))->required(),
               TextInput::make('customer_tel_number')->label(__('trans.customer_tel_number.text'))->required(),
               Fieldset::make('ที่อยู่เจ้าของรถ')
                    ->schema([
                        TextInput::make('address')->label(__('trans.address.text'))->required()->columnSpanFull(),
                        Select::make('postal_code')
                            ->label(__('trans.postal_code.text'))
                            ->required()
                            ->preload()
                            ->searchable()
                            ->reactive()
                            ->options(function (Closure $get) {
                                $displayAddress = [];
                                $address = ThailandAddress::where('zipcode', 'like', '%' . $get('postal_code') . '%')
                                    ->get()
                                    ->toArray();

                                if ($address) {
                                    foreach ($address as $val) {
                                        $displayAddress[Arr::get($val, 'id')] = Arr::get($val, 'zipcode')
                                            . ' '
                                            . Arr::get($val, 'district')
                                            . ' '
                                            . Arr::get($val, 'amphoe')
                                            . ' '
                                            . Arr::get($val, 'province');
                                    }
                                }

                                return $displayAddress;
                            })
                            ->afterStateUpdated(function ($set, $state) {
                                if ($state) {
                                    $name = ThailandAddress::find($state)->toArray();
                                    if ($name) {
                                        $set('district', $name['district']);
                                        $set('amphoe', $name['amphoe']);
                                        $set('province', $name['province']);
                                    }
                                }
                            }),
                         TextInput::make('district')->label(__('trans.district.text'))->required(),
                         TextInput::make('amphoe')->label(__('trans.amphoe.text'))->required(),
                         TextInput::make('province')->label(__('trans.province.text'))->required(),
                    ]),
                TextInput::make('driver_name')->label(__('trans.driver_name.text'))->required(),
                TextInput::make('driver_tel_number')->label(__('trans.driver_tel_number.text'))->required(),
                DatePicker::make('pickup_date')->label(__('trans.pickup_date.text')),
                TextInput::make('mile_number')->label(__('trans.mile_number.text'))->required(),
                Select::make('repair_code')->label(__('trans.repair_code.text'))
                    ->required()
                    ->options([
                        'A' => 'A',
                        'B' => 'B',
                        'C' => 'C',
                        'D' => 'D'
                    ])
                    ->columns(5),
                MarkdownEditor::make('content')
                    ->label(__('trans.content.text'))
                    ->required()
                    ->toolbarButtons([
                        'bold',
                        'bulletList',
                        'edit',
                        'italic',
                        'orderedList',
                        'preview',
                        'strike',
                    ])->columnSpanFull(),
                Fieldset::make('ประเภทของรถที่เกิดอุบัติเหตุ')
                    ->schema([
                        Radio::make('car_accident')
                        ->label('ระบุตัวเลือกที่ต้องการ')
                        ->required()
                        ->options([
                            'รถประกัน' => 'รถประกัน',
                            'รถคู่กรณี' => 'รถคู่กรณี'
                        ])
                    ]),
                Fieldset::make('เลือกฝ่ายหรือคดีที่เกิดอุบัติเหตุ')
                    ->schema([
                        Radio::make('car_accident_choose')
                        ->label('ระบุตัวเลือกที่ต้องการ')
                        ->required()
                        ->options([
                            'ฝ่ายถูก'=>'ฝ่ายถูก',
                            'ฝ่ายผิด'=>'ฝ่ายผิด',
                            'คดี'=>'คดี',
                        ])
                    ]),
                Fieldset::make('เลือกตัวเลือกในการจ่ายค่าเสียหาย')
                    ->schema([
                        Radio::make('options')->label(__('trans.options.text'))
                        ->required()
                        ->reactive()
                        ->options([
                            'เคลมประกันบริษัท'=>'เคลมประกันบริษัท',
                            'เงินสด'=>'เงินสด'
                        ])
                    ]),
                Select::make('insu_company_name')
                    ->label(__('trans.insu_company_name.text'))
                    ->preload()
                    ->required()
                    ->hidden(fn (Closure $get) => $get('options') == 'เงินสด')
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
                TextInput::make('insu_company_address')
                ->label('ที่อยู่บริษัทประกันภัย')
                ->required()
                ->columnSpanFull()
                ->hidden(fn (Closure $get) => $get('options') == 'เงินสด'),
                TextInput::make('policy_number')
                    ->label(__('trans.policy_number.text'))
                    ->required()
                    ->hidden(fn (Closure $get) => $get('options') == 'เงินสด'),
                TextInput::make('noti_number')
                    ->label(__('trans.noti_number.text'))
                    ->required()
                    ->hidden(fn (Closure $get) => $get('options') == 'เงินสด'),
                TextInput::make('claim_number')
                    ->label(__('trans.claim_number.text'))
                    ->required()
                    ->hidden(fn (Closure $get) => $get('options') == 'เงินสด'),
                TextInput::make('sum_insured')
                    ->label(__('trans.sum_insured.text'))
                    ->required()
                    ->hidden(fn (Closure $get) => $get('options') == 'เงินสด'),
                DatePicker::make('policy_expiration_date')
                    ->label(__('trans.policy_expiration_date.text'))
                    ->required()
                    ->hidden(fn (Closure $get) => $get('options') == 'เงินสด'),
                DatePicker::make('accident_date')
                ->label(__('trans.accident_date.text'))
                ->required(),
                DatePicker::make('repair_date')
                ->label(__('trans.repair_date.text'))
                ->required(),
                TextInput::make('number_ab')
                ->label(__('trans.number_ab.text'))
                ->required(),
                Fieldset::make('ประเภทการจอด')
                    ->schema([
                        Radio::make('park_type')->label(__('trans.options.text'))
                        ->required()
                        ->options([
                            'จอดซ่อม' => 'จอดซ่อม',
                            'ไม่จอดซ่อม' => 'ไม่จอดซ่อม'
                        ]),
                        DatePicker::make('car_park')->label(__('trans.car_park.text')),
                    ]),
                Fieldset::make('สภาพรถและอุปกรณ์ที่มีติดรถในวันที่รถเข้าซ่อม')
                    ->schema([
                        Checkbox::make('spare_tire')->label(__('trans.spare_tire.text')),
                        Checkbox::make('jack_handle')->label(__('trans.jack_handle.text')),
                        Checkbox::make('boxset')->label(__('trans.boxset.text')),
                        Checkbox::make('batteries')->label(__('trans.batteries.text')),
                        Checkbox::make('cigarette_lighter')->label(__('trans.cigarette_lighter.text')),
                        Checkbox::make('radio')->label(__('trans.radio.text')),
                        Checkbox::make('floor_mat')->label(__('trans.floor_mat.text')),
                        Checkbox::make('spare_removal')->label(__('trans.spare_removal.text')),
                        Checkbox::make('fire_extinguisher')->label(__('trans.fire_extinguisher.text')),
                        Checkbox::make('spining_wheel')->label(__('trans.spining_wheel.text')),
                        Checkbox::make('other')->label(__('trans.other.text'))->columnSpanFull(),
                        MarkdownEditor::make('content_other')
                        ->label(__('trans.content_other.text'))
                        ->toolbarButtons([
                            'bold',
                            'bulletList',
                            'edit',
                            'italic',
                            'orderedList',
                            'preview',
                            'strike',
                        ]),
                    ]),
                Fieldset::make('เอกสารที่ได้รับในวันที่รถเข้าซ่อม')
                    ->schema([
                        FileUpload::make('real_claim')->label(__('trans.real_claim.text'))
                        ->image()
                        ->enableDownload(),
                        FileUpload::make('copy_claim')->label(__('trans.copy_claim.text'))
                        ->image()
                        ->enableDownload(),
                        FileUpload::make('copy_driver_license')->label(__('trans.copy_driver_license.text'))
                        ->image()
                        ->enableDownload(),
                        FileUpload::make('copy_vehicle_regis')->label(__('trans.copy_vehicle_regis.text'))
                        ->image()
                        ->enableDownload(),
                        FileUpload::make('copy_policy')->label(__('trans.copy_policy.text'))
                        ->image()
                        ->enableDownload(),
                        FileUpload::make('power_of_attorney')->label(__('trans.power_of_attorney.text'))
                        ->image()
                        ->enableDownload(),
                        FileUpload::make('copy_of_director_id_card')->label(__('trans.copy_of_director_id_card.text'))
                        ->image()
                        ->enableDownload(),
                        FileUpload::make('copy_of_person')->label(__('trans.copy_of_person.text'))
                        ->image()
                        ->enableDownload(),
                        FileUpload::make('account_book')->label(__('trans.account_book.text'))
                        ->image()
                        ->enableDownload(),
                        FileUpload::make('atm_card')->label(__('trans.atm_card.text'))
                        ->image()
                        ->enableDownload(),
                    ]),
                Fieldset::make('เอกสารที่ลูกค้านำมาวันรับรถ')
                    ->schema([
                        Checkbox::make('real_claim_document')->label(__('trans.real_claim.text')),
                        Checkbox::make('copy_policy_document')->label(__('trans.copy_policy.text')),
                        Checkbox::make('copy_claim_document')->label(__('trans.copy_claim.text')),
                        Checkbox::make('power_of_attorney_document')->label(__('trans.power_of_attorney.text')),
                        Checkbox::make('copy_driver_license_document')->label(__('trans.copy_driver_license.text')),
                        Checkbox::make('copy_of_director_id_card_document')->label(__('trans.copy_of_director_id_card.text')),
                        Checkbox::make('copy_vehicle_regis_document')->label(__('trans.copy_vehicle_regis.text')),
                        Checkbox::make('copy_of_person_document')->label(__('trans.copy_of_person.text')),
                        Checkbox::make('account_book_document')->label(__('trans.account_book.text')),
                        Checkbox::make('atm_card_document')->label(__('trans.atm_card.text')),
                        Checkbox::make('cassie_number')->label(__('เลขคัชชี')),
                        Checkbox::make('other_document')->label(__('trans.other.text'))->columnSpanFull(),
                        MarkdownEditor::make('content_document')
                            ->label(__('trans.content_document.text'))
                            ->toolbarButtons([
                                'bold',
                                'bulletList',
                                'edit',
                                'italic',
                                'orderedList',
                                'preview',
                                'strike',
                            ]),
                    ]),
                Fieldset::make('ภาพรถวันเข้าซ่อม')
                    ->schema([
                        FileUpload::make('front')->label(__('trans.front.text'))
                        ->image()
                        ->enableDownload(),
                        FileUpload::make('left')->label(__('trans.left.text'))
                        ->image()
                        ->enableDownload(),
                        FileUpload::make('right')->label(__('trans.right.text'))
                        ->image()
                        ->enableDownload(),
                        FileUpload::make('back')->label(__('trans.back.text'))
                        ->image()
                        ->enableDownload(),
                        FileUpload::make('inside_left')->label(__('trans.inside_left.text'))
                        ->image()
                        ->enableDownload(),
                        FileUpload::make('inside_right')->label(__('trans.inside_right.text'))
                        ->image()
                        ->enableDownload(),
                        FileUpload::make('inside_truck')->label(__('trans.truck.text'))
                        ->image()
                        ->enableDownload(),
                        FileUpload::make('etc')->label(__('trans.etc.text'))
                        ->image()
                        ->enableDownload(),
                        SpatieMediaLibraryFileUpload::make('other_file')
                            ->multiple()
                            ->label(__('trans.etc.text'))
                            ->image()
                            ->enableDownload(),
                    ]),
                TextInput::make('repairman')->label(__('trans.repairman.text'))->required(),
                TextInput::make('repairman_tel_number')->label(__('trans.repairman_tel_number.text'))->required(),
                FileUpload::make('id_card_attachment')->label(__('trans.id_card_attachment.text'))->required()
                ->image()
                ->enableDownload(),
                ViewField::make('user_admin')
                    ->view('filament.resources.forms.components.user-admin'),
                TextInput::make('timex')
                    ->label(__('trans.timex.text'))
                    ->default(now()->format('H:i:s'))
                    ->disabled(),
                TextInput::make('updated_at')
                    ->label(__('trans.updated_at.text'))
                    ->disabled()
                    ->afterStateHydrated(function ($set, $state) {
                        if ($state) {
                            $set('updated_at', $state);
                        } else {
                            $set('updated_at', now()->format('Y-m-d H:i:s'));
                        }

                        $set('addressee', Filament::auth()->user()->name);
                    }),
                ViewField::make('editor_name')
                    ->view('filament.resources.forms.components.editor-name'),
                Hidden::make('addressee')
            ]
        );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('job_number')
                    ->label(__('trans.job_number.text'))
                    ->searchable()->toggleable()->sortable(),
                TextColumn::make('addressee')
                    ->label(__('trans.addressee.text')),
                TextColumn::make('receive_date')
                    ->label(__('trans.receive_date.text'))
                    ->formatStateUsing(fn (?string $state): string => convertYmdToThaiShort($state)),
                TextColumn::make('timex')
                    ->label(__('trans.timex.text'))
                    ->formatStateUsing(fn (?string $state): string => convertHisToHi($state)),
                TextColumn::make('customer')
                    ->label(__('trans.customer.text')),
                TextColumn::make('repairman')
                    ->label(__('trans.repairman.text')),
                TextColumn::make('pickup_date')
                    ->label(__('trans.pickup_date.text'))
                    ->formatStateUsing(fn (?string $state): string => convertYmdToThaiShort($state)),
                TextColumn::make('vehicle_registration')
                    ->label(__('trans.vehicle_registration.text'))
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('brand')
                    ->label(__('trans.brand.text')),
                TextColumn::make('model')
                    ->label(__('trans.model.text')),
                TextColumn::make('car_type')
                    ->label(__('trans.car_type.text')),
                TextColumn::make('car_year')
                    ->label(__('trans.car_year.text')),
                TextColumn::make('mile_number')
                    ->label(__('trans.mile_number.text')),
                TextColumn::make('repair_code')
                    ->label(__('trans.repair_code.text')),
                TextColumn::make('options')
                    ->label(__('trans.options.text')),
                TextColumn::make('insu_company_name')
                    ->label(__('trans.insu_company_name.text')),
                TextColumn::make('policy_number')
                    ->label(__('trans.policy_number.text')),
                TextColumn::make('noti_number')
                    ->label(__('trans.noti_number.text')),
                TextColumn::make('claim_number')
                    ->label(__('trans.claim_number.text')),
                TextColumn::make('park_type')
                    ->label(__('trans.park_type.text')),
                TextColumn::make('car_park')
                    ->label(__('trans.car_park.text')),
                ImageColumn::make('real_claim')
                    ->label(__('trans.real_claim.text'))->size(150),
                ImageColumn::make('real_claim')
                ->label(__('trans.real_claim.text'))->size(150),
                ImageColumn::make('copy_claim')
                ->label(__('trans.copy_claim.text'))->size(150),
                ImageColumn::make('copy_driver_license')
                    ->label(__('trans.copy_driver_license.text'))->size(150),
                ImageColumn::make('copy_vehicle_regis')
                ->label(__('trans.copy_vehicle_regis.text'))->size(150),
                ImageColumn::make('copy_policy')
                    ->label(__('trans.copy_policy.text'))->size(150),
                ImageColumn::make('power_of_attorney')
                    ->label(__('trans.power_of_attorney.text'))->size(150),
                ImageColumn::make('copy_of_director_id_card')
                ->label(__('trans.copy_of_director_id_card.text'))->size(150),
                ImageColumn::make('copy_of_person')
                    ->label(__('trans.copy_of_person.text'))->size(150),
                ImageColumn::make('atm_card')
                    ->label(__('trans.atm_card.text'))->size(150),
                ImageColumn::make('account_book')
                ->label(__('trans.account_book.text'))->size(150),
                ImageColumn::make('front')
                ->label(__('trans.front.text'))->size(150),
                ImageColumn::make('left')
                    ->label(__('trans.left.text'))->size(150),
                ImageColumn::make('right')
                ->label(__('trans.right.text'))->size(150),
                ImageColumn::make('back')
                    ->label(__('trans.back.text'))->size(150),
                ImageColumn::make('inside_left')
                    ->label(__('trans.inside_left.text'))->size(150),
                ImageColumn::make('inside_right')
                ->label(__('trans.inside_right.text'))->size(150),
                ImageColumn::make('truck')
                    ->label(__('trans.truck.text'))->size(150),
                ImageColumn::make('etc')
                    ->label(__('trans.etc.text'))->size(150),
                TextColumn::make('updated_at')
                    ->label(__('trans.updated_at.text'))
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
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCarReceives::route('/'),
            'create' => Pages\CreateCarReceive::route('/create'),
            'edit' => Pages\EditCarReceive::route('/{record}/edit'),
        ];
    }

    public static function canDelete(Model $record): bool
    {
        return Filament::auth()->user()->email === 'super@admin.com';
    }
}




