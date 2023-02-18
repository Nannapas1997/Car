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
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema(static::getViewData('job_number')),
                TextInput::make('staff_name')->label('ชื่อ (ข้าพเจ้า)'),
                TextInput::make('staff_position')->label('ตำแหน่งที่เกี่ยวข้องกับ บจ./หจก.'),
                TextInput::make('brand')->label('ยี่ห้อรถที่มารับ'),
                TextInput::make('vehicle_registration')->label('เลขทะเบียนรถ'),
                TextInput::make('choose_garage')->label('จากบริษัท (SP / SBO)'),
                TextInput::make('insu_company_name')->label('ชื่อบริษัทประกันภัยของรถ'),
                TextInput::make('policy_number')->label('เลขกรมธรรม์'),
                TextInput::make('claim_number')->label('เลขเคลม / เลขรับแจ้งที่'),
                TextInput::make('save_repair_cost_id')
                    ->label('save_repair_cost_id')
                    ->numeric()
                    ->default(1),
                TextInput::make('code_c0_c7')
                    ->label('code_c0_c7')
                    ->default('-'),
                TextInput::make('price')
                    ->label('price')
                    ->default('-'),
                TextInput::make('spare_code')
                    ->label('spare_code')
                    ->default('-'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('job_number')->label(__('trans.job_number.text')),
                TextColumn::make('staff_name')->label(__('ชื่อ (ข้าพเจ้า)')),
                TextColumn::make('staff_position')->label(__('ตำแหน่งที่เกี่ยวข้องกับ บจ./หจก.')),
                TextColumn::make('vehicle_registration')->label(__('trans.vehicle_registration.text')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
//                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListCarReleases::route('/'),
            'create' => Pages\CreateCarRelease::route('/create'),
            'edit' => Pages\EditCarRelease::route('/{record}/edit'),
        ];
    }
}
