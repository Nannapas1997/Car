<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\CashReceipt;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CashReceiptResource\Pages;
use App\Filament\Resources\CashReceiptResource\RelationManagers;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CheckboxList;
use Filament\Tables\Columns\TextColumn;

class CashReceiptResource extends Resource
{
    protected static ?string $model = CashReceipt::class;
    protected static ?string $navigationGroup = 'Financial';
    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('disbursement_amount')
                ->label(__('trans.disbursement_amount.text'))
                ->required(),
                DatePicker::make('date')
                ->label(__('trans.date.text')),
                Fieldset::make('ประเภทของการค่าใช้จ่ายต่างๆ')
                ->schema([
                    Checkbox::make('buy_consumables')->label(__('trans.buy_consumables.text')),
                    Checkbox::make('buy_spare')->label(__('trans.buy_spare.text')),
                    Checkbox::make('oil')->label(__('trans.oil.text')),
                    Checkbox::make('common_expenses')->label(__('trans.common_expenses.text')),
                    Checkbox::make('transportation_cost')->label(__('trans.transportation_cost.text')),
                    Checkbox::make('customer_testimonials')->label(__('trans.customer_testimonials.text')),
                    Checkbox::make('insurance_certification')->label(__('trans.insurance_certification.text')),
                    Checkbox::make('internal_certification_fee')->label(__('trans.internal_certification_fee.text')),
                ]),
                TextInput::make('courier_document')
                ->label(__('trans.courier_document.text'))
                ->required(),
                TextInput::make('recipient_document')
                ->label(__('trans.recipient_document.text'))
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('date')->label(__('trans.date.text')),
                TextColumn::make('courier_document')->label(__('trans.courier_document.text')),
                TextColumn::make('recipient_document')->label(__('trans.recipient_document.text')),
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
            'index' => Pages\ListCashReceipts::route('/'),
            'create' => Pages\CreateCashReceipt::route('/create'),
            'edit' => Pages\EditCashReceipt::route('/{record}/edit'),
        ];
    }
}
