<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\CarReceive;
use Filament\Resources\Form;
use Filament\Resources\Table;
use App\Models\SaveRepairCosts;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\SaveRepairCostsResource\Pages;
use App\Filament\Resources\SaveRepairCostsResource\RelationManagers;
use App\Filament\Resources\SaveRepairCostsResource\Widgets\SaveRepairCosts as WidgetsSaveRepairCosts;

class SaveRepairCostsResource extends Resource
{
    protected static ?string $model = SaveRepairCosts::class;
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
                                $set('job_number_control', $name['job_number']);
                                $set('customer', $name['customer']);
                                $set('vehicle_registration', $name['vehicle_registration']);
                                $set('brand', $name['brand']);
                                $set('model', $name['model']);
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

                    Group::make()
                    ->schema([
                        Card::make()
                            ->schema(static::getFormSchema())
                            ->columns(2),

                        Forms\Components\Section::make('Order items')
                            ->schema(static::getFormSchema('items')),
                    ])
                ])->columnSpan('full'),
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
            'create' => Pages\CreateSaveRepairCosts::route('/create'),
            'edit' => Pages\EditSaveRepairCosts::route('/{record}/edit'),
        ];
    }
}
