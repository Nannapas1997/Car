<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\CarReceive;
use Illuminate\Support\Arr;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Facades\Filament;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use App\Models\PriceControlBills;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PriceControlBillsResource\Pages;
use App\Filament\Resources\PriceControlBillsResource\RelationManagers;

class PriceControlBillsResource extends Resource
{
    protected static ?string $model = PriceControlBills::class;
    protected static ?string $navigationGroup = 'บัญชี';
    protected static ?string $navigationLabel = 'ใบคุมราคา';
    protected static ?string $navigationIcon = 'heroicon-o-receipt-tax';
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
            Select::make('job_number_control')
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
                            $set('insu_company_name', $name['insu_company_name']);
                            $set('noti_number', $name['noti_number']);
                            $set('number_ab', $name['number_ab']);
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
                TextInput::make('number_price_control')->label(__('trans.number_price_control.text')),
                TextInput::make('noti_number')->label(__('trans.noti_number.text'))->required()->disabled(),
                TextInput::make('number_ab')->label(__('trans.number_ab.text'))->required()->disabled(),
                TextInput::make('customer')->label(__('trans.customer.text'))->required()->disabled(),
                TextInput::make('vehicle_registration')->label(__('trans.vehicle_registration.text'))->required()->disabled(),
                TextInput::make('insu_company_name')->label(__('trans.insu_company_name.text'))->required()->disabled(),
                TextInput::make('termination_price')->label(__('trans.termination_price.text'))->required(),
                TextInput::make('note')->label(__('trans.note.text'))->required(),
                TextInput::make('courier')->label(__('trans.courier.text'))->required(),
                TextInput::make('price_dealer')->label(__('trans.price_dealer.text'))->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('job_number_control')->label(__('trans.job_number.text')),
                TextColumn::make('number_price_control')->label(__('trans.number_price_control.text')),
                TextColumn::make('noti_number')->label(__('trans.noti_number.text')),
                TextColumn::make('number_ab')->label(__('trans.number_ab.text')),
                TextColumn::make('customer')->label(__('trans.customer.text')),
                TextColumn::make('vehicle_registration')->label(__('trans.vehicle_registration.text')),
                TextColumn::make('insu_company_name')->label(__('trans.insu_company_name.text')),
                TextColumn::make('termination_price')->label(__('trans.termination_price.text')),
                TextColumn::make('note')->label(__('trans.note.text')),
                TextColumn::make('courier')->label(__('trans.courier.text')),
                TextColumn::make('price_dealer')->label(__('trans.price_dealer.text')),
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
            'index' => Pages\ListPriceControlBills::route('/'),
            'create' => Pages\CreatePriceControlBills::route('/create'),
            'edit' => Pages\EditPriceControlBills::route('/{record}/edit'),
        ];
    }
    public static function canDelete(Model $record): bool
    {
        return Filament::auth()->user()->email === 'super@admin.com';
    }
}
