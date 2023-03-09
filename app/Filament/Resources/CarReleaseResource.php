<?php

namespace App\Filament\Resources;

use Filament\Tables;
use App\Models\CarReceive;
use App\Models\CarRelease;
use Illuminate\Support\Arr;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Facades\Filament;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Config;
use App\Filament\Traits\JobNumberTrait;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\CarReleaseResource\Pages;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\Resources\CarReleaseResource\RelationManagers;

class CarReleaseResource extends Resource
{
    use JobNumberTrait;

    protected static ?string $model = CarRelease::class;
    protected static ?string $navigationGroup = 'บัญชี';
    protected static ?string $navigationLabel = 'ใบปล่อยรถ';
    protected static ?string $navigationIcon = 'heroicon-o-arrows-expand';
    protected static ?string $pluralLabel = 'ใบปล่อยรถ';

    public static function OCData(): array
    {
        $currentGarage =  Filament::auth()->user()->garage;
        $optionData = CarRelease::query()
            ->where('choose_garage', $currentGarage)
            ->orderBy('oc_number', 'desc')
            ->get('oc_number')
            ->pluck('oc_number', 'oc_number')
            ->toArray();
        $optionValue = [];

        if (!$optionData) {
            $ocNumberFirst = 'OC' . now()->format('-y-m-d-') . '00001';
            $optionData[$ocNumberFirst] = $ocNumberFirst;
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
        }

        foreach ($optionData as $val) {
            $optionValue[$val] = $val;
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
        $currentGarage =  Filament::auth()->user()->garage;

        return $form
            ->schema([
                Card::make()->schema(
                    static::getViewData($currentGarage, function ($set, $state) use ($currentGarage) {
                        if ($state) {
                            $carReceive = CarReceive::query()->where('job_number', $state)->first();
                            if ($carReceive) {
                                $carReceive = $carReceive->toArray();
                                $set('choose_garage', $carReceive['choose_garage']);
                                $set('policy_number', $carReceive['policy_number']);
                                $set('vehicle_registration', $carReceive['vehicle_registration']);
                                $set('insu_company_name', $carReceive['insu_company_name']);
                                $set('claim_number', $carReceive['claim_number']);
                                $set('brand', $carReceive['brand']);
                            }
                        }
                    })
                ),
                Card::make()->schema(static::OCData()),
                TextInput::make('staff_name')
                    ->label('ชื่อ (ข้าพเจ้า)'),
                TextInput::make('staff_position')
                    ->label('ตำแหน่งที่เกี่ยวข้องกับ บจ./หจก.'),
                Select::make('brand')
                    ->label(__('trans.brand.text'))
                    ->required()
                    ->disabled()
                    ->options(Config::get('static.car-brand'))
                    ->columns(65),
                TextInput::make('vehicle_registration')
                    ->label('เลขทะเบียนรถ')
                    ->disabled(),
                Select::make('insu_company_name')
                    ->label(__('trans.insu_company_name.text'))
                    ->preload()
                    ->disabled()
                    ->options(Config::get('static.insu-company')),
                TextInput::make('policy_number')
                    ->label('เลขกรมธรรม์')
                    ->disabled(),
                TextInput::make('claim_number')
                    ->label('เลขเคลม / เลขรับแจ้งที่')
                    ->disabled(),
                Fieldset::make('เอกสารที่ได้รับในวันที่รถเข้าซ่อม')
                    ->schema(
                        [
                            FileUpload::make('real_claim')
                                ->label(__('trans.real_claim.text'))
                                ->image()
                                ->enableDownload(),
                            FileUpload::make('copy_claim')
                                ->label(__('trans.copy_claim.text'))
                                ->image()
                                ->enableDownload(),
                            FileUpload::make('copy_driver_license')
                                ->label(__('trans.copy_driver_license.text'))
                                ->image()
                                ->enableDownload(),
                            FileUpload::make('copy_vehicle_regis')
                                ->label(__('trans.copy_vehicle_regis.text'))
                                ->image()
                                ->enableDownload(),
                            FileUpload::make('copy_policy')
                                ->label(__('trans.copy_policy.text'))
                                ->image()
                                ->enableDownload(),
                            FileUpload::make('power_of_attorney')
                                ->label(__('trans.power_of_attorney.text'))
                                ->image()
                                ->enableDownload(),
                            FileUpload::make('copy_of_director_id_card')
                                ->label(__('trans.copy_of_director_id_card.text'))
                                ->image()
                                ->enableDownload(),
                            FileUpload::make('copy_of_person')
                                ->label(__('trans.copy_of_person.text'))
                                ->image()
                                ->enableDownload(),
                            FileUpload::make('account_book')
                                ->label(__('trans.account_book.text'))
                                ->image()
                                ->enableDownload(),
                            FileUpload::make('atm_card')
                                ->label(__('trans.atm_card.text'))
                                ->image()
                                ->enableDownload(),
                            SpatieMediaLibraryFileUpload::make('cassie_number')
                                ->label(__('trans.cassie_number.text'))
                                ->image()
                                ->enableDownload(),
                        ]
                    ),
                Fieldset::make('เอกสารที่ลูกค้านำมาวันรับรถ')
                    ->schema(
                        [
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
                            Checkbox::make('cassie_number_document')->label(__('trans.cassie_number.text')),
                        ]
                    ),
                TextInput::make('car_releaser')
                    ->label('ผู้ปล่อยรถ'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('job_number')
                    ->label(__('trans.job_number.text'))
                    ->searchable(),
                TextColumn::make('oc_number')->label(__('trans.oc_number.text')),
                TextColumn::make('car_releaser')->label(__('ผู้ปล่อยรถ')),
                TextColumn::make('staff_name')->label(__('ชื่อ (ข้าพเจ้า)')),
                TextColumn::make('staff_position')->label(__('ตำแหน่งที่เกี่ยวข้องกับ บจ./หจก.')),
                TextColumn::make('vehicle_registration')
                    ->label(__('trans.vehicle_registration.text'))
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from')
                            ->placeholder(fn ($state): string => 'Dec 18, ' . now()->subYear()->format('Y')),
                        DatePicker::make('created_until')
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
                Tables\Actions\DeleteAction::make(),
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
}
