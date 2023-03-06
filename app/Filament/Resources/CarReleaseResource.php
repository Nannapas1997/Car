<?php

namespace App\Filament\Resources;

use App\Filament\Traits\JobNumberTrait;
use Filament\Forms\Components\DatePicker;
use Filament\Tables;
use App\Models\CarReceive;
use App\Models\CarRelease;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Facades\Filament;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\CarReleaseResource\Pages;
use App\Filament\Resources\CarReleaseResource\RelationManagers;
use Illuminate\Support\Facades\Config;

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
