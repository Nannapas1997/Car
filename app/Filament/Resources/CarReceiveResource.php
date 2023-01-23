<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\CarReceive;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Livewire\TemporaryUploadedFile;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Http\Livewire\GlobalSearch;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MultiSelect;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CarReceiveResource\Pages;
use App\Filament\Resources\CarReceiveResource\RelationManagers;


class CarReceiveResource extends Resource
{
    protected static ?string $model = CarReceive::class;
    protected static ?string $navigationGroup = 'My Work';
    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Radio::make('choose_garage')->label(__('trans.choose_garage.text'))->options(['SP' => 'SP auto','SBO' => 'SBO'])->columns(3),
            Select::make('job_number')->label(__('trans.job_number.text'))->preload()->options(CarReceive::query()->pluck('job_number')),
            TextInput::make('job_number(new_customer)')->label( __ ('trans.new_customer.text')),
            DatePicker::make('receive_date')->label(__('trans.receive_date.text'))->required(),
            TimePicker::make('time')->label(__('trans.time.text')),
            TextInput::make('customer')->label(__('trans.customer.text'))->required(),
            TextInput::make('repairman')->label(__('trans.repairman.text'))->required(),
            TextInput::make('tel_number')->label(__('trans.tel_number.text'))->required(),
            DatePicker::make('pickup_date')->label(__('trans.pickup_date.text')),
            TextInput::make('vehicle_registration')->label(__('trans.vehicle_registration.text'))->required(),
            Select::make('brand')->label(__('trans.brand.text'))->required()->options(['Toyota' => 'Toyota','Isuzu' => 'Isuzu','Honda' => 'Honda', 'Mitsubishi'=>'Mitsubishi','Nissan'=>'Nissan','Mazda'=>'Mazda','Ford'=>'Ford','MG'=>'MG','Suzuki'=>'Suzuki','Kia'=>'Kia','Hyundai'=>'Hyundai','Volvo'=>'Volvo','Subaru'=>'Subaru'])->columns(14),
            TextInput::make('model')->label(__('trans.model.text'))->required(),
            TextInput::make('car_type')->label(__('trans.car_type.text'))->required(),
            TextInput::make('mile_number')->label(__('trans.mile_number.text'))->required(),
            Select::make('repair_code')->label(__('trans.repair_code.text'))->required()->options(['A' => 'A','B' => 'B', 'C'=>'C', 'D'=>'D'])->columns(5),
            Radio::make('options')->label(__('trans.options.text'))->options(['รถประกัน' => 'รถประกัน','รถคู่กรณี' => 'รถคู่กรณี','ฝ่ายถูก'=>'ฝ่ายถูก','ฝ่ายผิด'=>'ฝ่ายผิด','คดี'=>'คดี','เคลมประกันบริษัท'=>'เคลมประกันบริษัท','เงินสด'=>'เงินสด'])->columns(8)->required(),
            TextInput::make('insu_company_name')->label(__('trans.insu_company_name.text'))->required(),
            TextInput::make('policy_number')->label(__('trans.policy_number.text'))->required(),
            TextInput::make('noti_number')->label(__('trans.noti_number.text'))->required(),
            TextInput::make('claim_number')->label(__('trans.claim_number.text'))->required(),
            Radio::make('park_type')->label(__('trans.park_type.text'))->options(['จอดซ่อม' => 'จอดซ่อม','ไม่จอดซ่อม' => 'ไม่จอดซ่อม'])->columns(3),
            DatePicker::make('car_park')->label(__('trans.car_park.text'))->required(),
            FileUpload::make('real_claim')->label(__('trans.real_claim.text')),
            FileUpload::make('copy_claim')->label(__('trans.copy_claim.text')),
            FileUpload::make('copy_driver_license')->label(__('trans.copy_driver_license.text')),
            FileUpload::make('copy_vehicle_regis')->label(__('trans.copy_vehicle_regis.text')),
            FileUpload::make('copy_policy')->label(__('trans.copy_policy.text')),
            FileUpload::make('power_of_attorney')->label(__('trans.power_of_attorney.text')),
            FileUpload::make('copy_of_director_id_card')->label(__('trans.copy_of_director_id_card.text')),
            FileUpload::make('copy_of_person')->label(__('trans.copy_of_person.text')),
            FileUpload::make('account_book')->label(__('trans.account_book.text')),
            FileUpload::make('atm_card')->label(__('trans.atm_card.text')),
            FileUpload::make('front')->label(__('trans.front.text')),
            FileUpload::make('left')->label(__('trans.left.text')),
            FileUpload::make('right')->label(__('trans.right.text')),
            FileUpload::make('back')->label(__('trans.back.text')),
            FileUpload::make('inside_left')->label(__('trans.inside_left.text')),
            FileUpload::make('inside_right')->label(__('trans.inside_right.text')),
            FileUpload::make('inside_truck')->label(__('trans.truck.text')),
            FileUpload::make('etc')->label(__('trans.etc.text')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('choose_garage')->label(__('trans.choose_garage.text')),
                TextColumn::make('job_number')->label(__('trans.job_number.text')),
                TextColumn::make('job_number(new_customer)')->label( __ ('trans.new_customer.text')),
                TextColumn::make('receive_date')->label(__('trans.receive_date.text')),
                TextColumn::make('time')->label(__('trans.time.text')),
                TextColumn::make('customer')->label(__('trans.customer.text')),
                TextColumn::make('repairman')->label(__('trans.repairman.text')),
                TextColumn::make('tel_number')->label(__('trans.tel_number.text')),
                TextColumn::make('pickup_date')->label(__('trans.pickup_date.text')),
                TextColumn::make('vehicle_registration')->label(__('trans.vehicle_registration.text')),
                TextColumn::make('brand')->label(__('trans.brand.text')),
                TextColumn::make('model')->label(__('trans.model.text')),
                TextColumn::make('car_type')->label(__('trans.car_type.text')),
                TextColumn::make('mile_number')->label(__('trans.mile_number.text')),
                TextColumn::make('repair_code')->label(__('trans.repair_code.text')),
                TextColumn::make('options')->label(__('trans.options.text')),
                TextColumn::make('insu_company_name')->label(__('trans.insu_company_name.text')),
                TextColumn::make('policy_number')->label(__('trans.policy_number.text')),
                TextColumn::make('noti_number')->label(__('trans.noti_number.text')),
                TextColumn::make('claim_number')->label(__('trans.claim_number.text')),
                TextColumn::make('park_type')->label(__('trans.park_type.text')),
                TextColumn::make('car_park')->label(__('trans.car_park.text')),
                ImageColumn::make('real_claim')->label(__('trans.real_claim.text')),
                ImageColumn::make('copy_claim')->label(__('trans.copy_claim.text')),
                ImageColumn::make('copy_driver_license')->label(__('trans.copy_driver_license.text')),
                ImageColumn::make('copy_vehicle_regis')->label(__('trans.copy_vehicle_regis.text')),
                ImageColumn::make('copy_policy')->label(__('trans.copy_policy.text')),
                ImageColumn::make('power_of_attorney')->label(__('trans.power_of_attorney.text')),
                ImageColumn::make('copy_of_director_id_card')->label(__('trans.copy_of_director_id_card.text')),
                ImageColumn::make('copy_of_person')->label(__('trans.copy_of_person.text')),
                ImageColumn::make('account_book')->label(__('trans.account_book.text')),
                ImageColumn::make('atm_card')->label(__('trans.atm_card.text')),
                ImageColumn::make('front')->label(__('trans.front.text')),
                ImageColumn::make('left')->label(__('trans.left.text')),
                ImageColumn::make('right')->label(__('trans.right.text')),
                ImageColumn::make('back')->label(__('trans.back.text')),
                ImageColumn::make('inside_left')->label(__('trans.inside_left.text')),
                ImageColumn::make('inside_right')->label(__('trans.inside_right.text')),
                ImageColumn::make('inside_truck')->label(__('trans.truck.text')),
                ImageColumn::make('etc')->label(__('trans.etc.text')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                DeleteAction::make(),
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
            'index' => Pages\ListCarReceives::route('/'),
            'create' => Pages\CreateCarReceive::route('/create'),
            'edit' => Pages\EditCarReceive::route('/{record}/edit'),
        ];
    }
}
