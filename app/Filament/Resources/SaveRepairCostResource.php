<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\CarReceive;
use Filament\Resources\Form;
use Filament\Resources\Table;
use App\Models\SaveRepairCost;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SaveRepairCostResource\Pages;
use App\Filament\Resources\SaveRepairCostResource\RelationManagers;
use Filament\Forms\Components\Repeater;

class SaveRepairCostResource extends Resource
{
    protected static ?string $model = SaveRepairCost::class;
    protected static ?string $navigationGroup = 'Account';
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('job_number_control')
                ->label(__('trans.job_number.text'))
                ->preload()
                ->required()
                ->options(CarReceive::pluck('job_number', 'id')->toArray())
                    ->searchable()
                    ->reactive()
                    ->afterStateUpdated(function ($set, $state) {
                        if ($state) {
                            $name = CarReceive::find($state)->toArray();
                            if ($name) {
                                $set('customer', $name['customer']);
                                $set('vehicle_registration', $name['vehicle_registration']);
                                $set('brand', $name['brand']);
                                $set('model', $name['model']);
                                $set('job_number_control', $name['job_number']);
                            }
                        }

                    }),

                TextInput::make('customer')->label(__('trans.customer.text'))->required(),
                TextInput::make('vehicle_registration')->label(__('trans.vehicle_registration.text'))->required(),
                TextInput::make('brand')->label(__('trans.brand.text'))->required(),
                TextInput::make('model')->label(__('trans.model.text'))->required(),
                TextInput::make('car_year')->label(__('trans.car_year.text'))->required(),
                Card::make()
                ->schema([


                        Card::make()
                            ->schema([
                                Placeholder::make('รายการค่าใช้จ่าย'),
                                Repeater::make('saveRepairCostItems')
                                ->relationship()
                                ->schema(
                                    [
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
                                            'md' => 2,
                                        ]),
                                        TextInput::make('price')->label(__('trans.price.text'))
                                        ->columnSpan([
                                            'md' => 3,
                                        ])
                                        ->required(),
                                        TextInput::make('spare_code')->label(__('trans.spare_code.text'))
                                        ->columnSpan([
                                            'md' => 3,
                                        ]),
                                    ])
                                ->defaultItems(count: 1)
                                ->columns([
                                    'md' => 8,
                                ]) ->createItemButtonLabel('เพิ่มรายการค่าใช้จ่าย'),

                            ])->columnSpan('full')

                        ]),
                TextInput::make('spare_cost')->label(__('trans.spare_cost.text'))->required(),
                TextInput::make('wage')->label(__('trans.wage.text'))->required(),
                TextInput::make('expense_not_receipt')->label(__('trans.expense_not_receipt.text'))->required(),
                TextInput::make('total')->label(__('trans.total.text'))->required(),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('job_number')->label(__('trans.job_number.text')),
                TextColumn::make('vehicle_registration')->label(__('trans.vehicle_registration.text')),
                TextColumn::make('customer')->label(__('trans.customer.text')),
                TextColumn::make('vehicle_registration')->label(__('trans.vehicle_registration.text')),
                TextColumn::make('brand')->label(__('trans.brand.text')),
                TextColumn::make('model')->label(__('trans.model.text')),
                TextColumn::make('car_year')->label(__('trans.car_year.text')),
                TextColumn::make('wage')->label(__('trans.wage.text')),
                TextColumn::make('spare_cost')->label(__('trans.spare_cost.text')),
                TextColumn::make('expense_not_receipt')->label(__('trans.expense_not_receipt.text')),
                TextColumn::make('total')->label(__('trans.total.text')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()->disabled(),
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
            'index' => Pages\ListSaveRepairCosts::route('/'),
            'create' => Pages\CreateSaveRepairCost::route('/create'),
            'edit' => Pages\EditSaveRepairCost::route('/{record}/edit'),
        ];
    }
}
