<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\CarReceive;
use App\Models\Requisition;
use Illuminate\Support\Arr;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RequisitionResource\Pages;
use App\Filament\Resources\RequisitionResource\RelationManagers;
use Filament\Tables\Columns\TextColumn;

class RequisitionResource extends Resource
{
    protected static ?string $model = Requisition::class;
    protected static ?string $navigationGroup = 'Account';
    protected static ?string $navigationIcon = 'heroicon-o-receipt-refund';
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
                            $set('vehicle_registration', $name['vehicle_registration']);
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
                TextInput::make('vehicle_registration')
                ->label(__('trans.vehicle_registration.text'))
                ->required(),
                DatePicker::make('date')
                ->label(__('trans.date.text'))
                ->required()
                ->default(now()->format('Y-m-d')),
                TextInput::make('pickup_time')
                ->label(__('trans.pickup_time.text'))
                ->required()
                ->default(now()->format('H:i:s')),
                TextInput::make('parts_list')
                ->label(__('trans.parts_list.text'))
                ->required(),
                TextInput::make('spare_code')
                ->label(__('trans.spare_code.text'))
                ->required(),
                Card::make()
                    ->schema([
                        Placeholder::make('รายการเบิก'),
                        Repeater::make('requisitionitems')
                        ->relationship()
                        ->schema(
                            [
                                TextInput::make('picking_list')->label(__('trans.picking_list.text'))
                                ->columnSpan([
                                    'md' => 6,
                                ])
                                ->required(),
                                TextInput::make('quantity')->label(__('trans.quantity.text'))
                                ->numeric()
                                ->columnSpan([
                                    'md' => 2,
                                ])->required(),
                                TextInput::make('unit')->label(__('trans.unit.text'))
                                ->columnSpan([
                                    'md' => 3,
                                ])->required(),
                            ])
                        ->defaultItems(count: 1)
                        ->columns([
                            'md' => 11,
                        ])->createItemButtonLabel('เพิ่มรายการเบิกของ'),

                    ])->columnSpan('full'),
                    TextInput::make('forerunner')
                    ->label(__('trans.forerunner.text'))
                    ->required(),
                    TextInput::make('approver')
                    ->label(__('trans.approver.text'))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('job_number')->label(__('trans.job_number.text')),
                TextColumn::make('vehicle_registration')->label(__('trans.vehicle_registration.text')),
                TextColumn::make('date')->label(__('trans.date.text')),
                TextColumn::make('pickup_time')->label(__('trans.pickup_time.text')),
                TextColumn::make('parts_list')->label(__('trans.parts_list.text')),
                TextColumn::make('spare_code')->label(__('trans.spare_code.text')),
                TextColumn::make('forerunner')->label(__('trans.forerunner.text')),
                TextColumn::make('approver')->label(__('trans.approver.text')),
            ])
            ->filters([
                //
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
            'index' => Pages\ListRequisitions::route('/'),
            'create' => Pages\CreateRequisition::route('/create'),
            'edit' => Pages\EditRequisition::route('/{record}/edit'),
        ];
    }
}
