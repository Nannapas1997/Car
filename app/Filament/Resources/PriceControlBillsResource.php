<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\CarReceive;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use App\Models\PriceControlBills;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PriceControlBillsResource\Pages;
use App\Filament\Resources\PriceControlBillsResource\RelationManagers;

class PriceControlBillsResource extends Resource
{
    protected static ?string $model = PriceControlBills::class;
    protected static ?string $navigationGroup = 'Account';
    protected static ?string $navigationIcon = 'heroicon-o-receipt-tax';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Select::make('job_number_control')
                ->label(__('trans.job_number.text'))
                ->preload()
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
                                $set('insu_company_name', $name['insu_company_name']);
                            }
                        }
                    }),
                TextInput::make('number_price_control')->label(__('trans.number_price_control.text'))->required(),
                TextInput::make('notification_number')->label(__('trans.notification_number.text'))->required(),
                TextInput::make('number_ab')->label(__('trans.number_ab.text'))->required(),
                TextInput::make('customer')->label(__('trans.customer.text'))->required(),
                TextInput::make('vehicle_registration')->label(__('trans.vehicle_registration.text'))->required(),
                TextInput::make('insu_company_name')->label(__('trans.insu_company_name.text'))->required(),
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
                TextColumn::make('notification_number')->label(__('trans.notification_number.text')),
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
            'index' => Pages\ListPriceControlBills::route('/'),
            'create' => Pages\CreatePriceControlBills::route('/create'),
            'edit' => Pages\EditPriceControlBills::route('/{record}/edit'),
        ];
    }
}
