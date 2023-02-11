<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Requisition;
use Filament\Resources\Form;
use Filament\Resources\Table;
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

class RequisitionResource extends Resource
{
    protected static ?string $model = Requisition::class;
    protected static ?string $navigationGroup = 'Account';
    protected static ?string $navigationIcon = 'heroicon-o-receipt-refund';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('job_number')
                ->label(__('trans.job_number.text'))
                ->required()
                ->preload()
                ->options([

                ]),
                Select::make('vehicle_registration')
                ->label(__('trans.vehicle_registration.text'))
                ->required()
                ->preload()
                ->options([

                ]),
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
                                TextInput::make('order')->label(__('trans.order.text'))
                                ->columnSpan([
                                    'md' => 1,
                                ])
                                ->required(),
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
                            'md' => 12,
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
                //
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
