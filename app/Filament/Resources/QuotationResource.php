<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Quotation;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use App\Filament\Resources\QuotationResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\QuotationResource\RelationManagers;
use Filament\Tables\Columns\BadgeColumn;

class QuotationResource extends Resource
{
    protected static ?string $model = Quotation::class;
    protected static ?string $navigationGroup = 'My Work';
    protected static ?string $navigationIcon = 'heroicon-o-document-search';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('job_number')
                ->label(__('trans.job_number.text'))
                ->required()
                ->preload()
                ->options([

                ]),
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
                ->required()
                ->preload()
                ->options([

                ]),
                TextInput::make('vehicle_registration')
                ->required()
                ->label(__('trans.vehicle_registration.text')),
                TextInput::make('number_items')
                ->required()
                ->label(__('trans.number_items.text')),
                TextInput::make('price')
                ->required()
                ->label(__('trans.price.text')),
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
                ->label(__('trans.quotation_date.text')),
                Card::make()
                    ->schema([
                        Placeholder::make('รายการอะไหล่ที่เสียหาย'),
                        Repeater::make('quotationitems')
                        ->relationship()
                        ->schema(
                            [
                                TextInput::make('order')->label(__('trans.order.text'))
                                ->columnSpan([
                                    'md' => 1,
                                ])
                                ->required(),
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
                                    'md' => 3,
                                ]),

                                TextInput::make('list_damaged_parts')->label(__('trans.list_damaged_parts.text'))
                                ->columnSpan([
                                    'md' => 3,
                                ])
                                ->required(),
                                TextInput::make('quantity')->label(__('trans.quantity.text'))
                                ->numeric()
                                ->columnSpan([
                                    'md' => 2,
                                ])->required(),
                                TextInput::make('spare_value')->label(__('trans.spare_value.text'))
                                ->columnSpan([
                                    'md' => 3,
                                ])->required(),
                            ])
                        ->defaultItems(count: 1)
                        ->columns([
                            'md' => 12,
                        ]) ->createItemButtonLabel('เพิ่มรายการอะไหล่ที่เสียหาย'),

                    ])->columnSpan('full'),
                    TextInput::make('sks')
                    ->required()
                    ->label(__('trans.sks.text')),
                    TextInput::make('wchp')
                    ->required()
                    ->label(__('trans.wchp.text')),
                    Select::make('store')->label(__('trans.store.text'))
                    ->required()
                    ->preload()
                    ->options([
                        'ร้านA'=>'ร้านA',
                        'ร้านB'=>'ร้านB',
                        'ร้านC'=>'ร้านC',
                        'ร้านD'=>'ร้านD',
                    ]),
                    TextInput::make('wage')
                    ->required()
                    ->label(__('trans.wage.text')),
                    TextInput::make('overall_price')
                    ->required()
                    ->label(__('trans.overall_price.text')),
                    TextInput::make('including_spare_parts')
                    ->required()
                    ->label(__('trans.including_spare_parts.text')),
                    TextInput::make('total_wage')
                    ->required()
                    ->label(__('trans.total_wage.text')),
                    TextInput::make('vat')
                    ->required()
                    ->label(__('trans.vat.text')),
                    TextInput::make('overall')
                    ->required()
                    ->label(__('trans.overall.text')),
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
                TextColumn::make('number_items')->label(__('trans.number_items.text')),
                TextColumn::make('price')->label(__('trans.price.text')),
                TextColumn::make('repair_code')->label(__('trans.repair_code.text')),
                TextColumn::make('car_type')->label(__('trans.car_type.text')),
                TextColumn::make('sum_insured')->label(__('trans.sum_insured.text')),
                TextColumn::make('creation_date')->label(__('trans.creation_date.text')),
                TextColumn::make('claim_number')->label(__('trans.claim_number.text')),
                TextColumn::make('accident_number')->label(__('trans.accident_number.text')),
                TextColumn::make('insu_company_name')->label(__('trans.insu_company_name.text')),
                TextColumn::make('accident_date')->label(__('trans.accident_date.text')),
                TextColumn::make('repair_date')->label(__('trans.repair_date.text')),
                TextColumn::make('sks')->label(__('trans.sks.text')),
                TextColumn::make('wchp')->label(__('trans.wchp.text')),
                TextColumn::make('list_damaged_parts')->label(__('trans.quotation_date.text')),
                TextColumn::make('store')->label(__('trans.store.text')),
                TextColumn::make('wage')->label(__('trans.wage.text')),
                TextColumn::make('total')->label(__('trans.total.text')),
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
