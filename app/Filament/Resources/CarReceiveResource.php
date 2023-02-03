<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Forms;
use Filament\Tables;

use App\Models\carReceive;
use Illuminate\Support\Str;
use Filament\Resources\Form;
use Filament\Resources\Table;
use App\Forms\Components\Search;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Illuminate\Support\Facades\Log;
use Livewire\TemporaryUploadedFile;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Forms\Components\TextInput;
use Filament\Http\Livewire\GlobalSearch;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\SelectColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CarReceiveResource\Pages;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\Resources\CarReceiveResource\RelationManagers;
use App\Models\User;

class CarReceiveResource extends Resource
{
    protected static ?string $model = CarReceive::class;
    protected static ?string $navigationGroup = 'My Work';
    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Radio::make('choose_garage')
                ->label(__('trans.choose_garage.text'))
                ->options(['SP' => 'SP auto','SBO' => 'SBO'])
                ->columns(3)
                ->required(),

            Select::make('search_regis')
                ->label(__('trans.search_regis.text'))
                ->preload()
                ->options(CarReceive::all()->pluck('vehicle_registration', 'id')->toArray())
                    ->searchable()
                    ->reactive()
                    ->afterStateUpdated(function ($set, $state) {
                        if ($state) {
                            $name = CarReceive::find($state)->toArray();
                            if ($name) {
                                $set('choose_garage', $name['choose_garage']);
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
                                $set('addressee', $name['addressee']);
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
                            }
                        }
                    }),
            TextInput::make('job_number_new')
                ->label( __ ('trans.new_customer.text'))
                ->reactive()
                ->afterStateUpdated(function (Closure $set, $state) {
                    $set('job_number', $state);
                }),
            Select::make('job_number')
                ->label(__('trans.job_number.text'))
                ->preload()
                ->options(CarReceive::all()->pluck('job_number')->toArray())
                    ->searchable()
                    ->reactive()
                    ->afterStateUpdated(function ($set, $state) {
                        if ($state) {
                            $name = CarReceive::find($state)->toArray();
                            if ($name) {
                                $set('choose_garage', $name['choose_garage']);
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
                                $set('addressee', $name['addressee']);
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
                                $set('copy_claim_document', $name['copy_claim_document']);
                                $set('copy_driver_license_document', $name['copy_driver_license_document']);
                                $set('copy_vehicle_regis_document', $name['copy_vehicle_regis_document']);
                                $set('copy_policy_document', $name['copy_policy_document']);
                                $set('power_of_attorney_document', $name['power_of_attorney_document']);
                                $set('copy_of_director_id_card_document', $name['copy_of_director_id_card_document']);
                                $set('copy_of_person_document', $name['copy_of_person_document']);
                                $set('account_book_document', $name['account_book_document']);
                                $set('atm_card_document', $name['atm_card_document']);
                            }
                        }
                    }),
            DatePicker::make('receive_date')->label(__('trans.receive_date.text'))->required(),
            TextInput::make('timex')->label(__('trans.timex.text')),
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
            MarkdownEditor::make('content')
                ->label(__('trans.content.text'))
                ->required()
                ->toolbarButtons([
                    'bold',
                    'bulletList',
                    'codeBlock',
                    'edit',
                    'italic',
                    'orderedList',
                    'preview',
                    'strike',
                ]),
            DatePicker::make('car_park')->label(__('trans.car_park.text')),
            TextInput::make('group_checkbox')->label(__('trans.group_checkbox.text'))->disabled()->columnSpanFull(),
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
            Checkbox::make('other')->label(__('trans.other.text')),
            TextInput::make('group_document')->label(__('trans.group_document.text'))->disabled()->columnSpanFull(),
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
            TextInput::make('customer_document')->label(__('trans.customer_document.text'))->disabled()->columnSpanFull(),
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
            Checkbox::make('other_document')->label(__('trans.other.text')),
            TextInput::make('group_car')->label(__('trans.group_car.text'))->disabled()->columnSpanFull(),
            FileUpload::make('front')->label(__('trans.front.text')),
            FileUpload::make('left')->label(__('trans.left.text')),
            FileUpload::make('right')->label(__('trans.right.text')),
            FileUpload::make('back')->label(__('trans.back.text')),
            FileUpload::make('inside_left')->label(__('trans.inside_left.text')),
            FileUpload::make('inside_right')->label(__('trans.inside_right.text')),
            FileUpload::make('inside_truck')->label(__('trans.truck.text')),
            FileUpload::make('etc')->label(__('trans.etc.text')),
            SpatieMediaLibraryFileUpload::make('other_file')
                ->multiple()
                ->label(__('trans.etc.text')),
            TextInput::make('repairman')->label(__('trans.repairman.text'))->required(),
            TextInput::make('user.name')->label(__('trans.addressee.text'))->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('choose_garage')->label(__('trans.choose_garage.text')),
                TextColumn::make('job_number')->label(__('trans.job_number.text')),
                TextColumn::make('receive_date')->label(__('trans.receive_date.text')),
                TextColumn::make('timex')->label(__('trans.timex.text')),
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
                SpatieMediaLibraryImageColumn::make('other_file')->conversion('thumb'),
            ])
            ->filters([
                //
            ])
            ->actions([


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
            'index' => Pages\ListCarReceives::route('/'),
            'create' => Pages\CreateCarReceive::route('/create'),
            'edit' => Pages\EditCarReceive::route('/{record}/edit'),
        ];
    }
}
