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
                    CheckboxList::make('group_checkbox')
                    ->label(__('trans.group_checkbox.text'))
                    ->required()
                    ->options([
                        'ซื้อวัสดุสิ้นเปลือง' => 'ซื้อวัสดุสิ้นเปลือง',
                        'ซื้ออะไหล่' => 'ซื้ออะไหล่',
                        'น้ำมัน' => 'น้ำมัน',
                        'ค่าใช้จ่ายส่วนกลาง' => 'ค่าใช้จ่ายส่วนกลาง',
                        'ค่างานขนส่ง' => 'ค่างานขนส่ง',
                        'ค่ารับรองลูกค้า' => 'ค่ารับรองลูกค้า',
                        'ค่ารับรองประกัน' => 'ค่ารับรองประกัน',
                        'ค่ารับรองภายใน' => 'ค่ารับรองภายใน',
                    ])
                ]),
                TextInput::make('other')
                ->label(__('trans.other.text'))
                ->required(),
                TextInput::make('forerunner')
                ->label(__('trans.forerunner.text'))
                ->required(),
                TextInput::make('financial')
                ->label(__('trans.financial.text'))
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('disbursement_amount')->label(__('trans.disbursement_amount.text')),
                TextColumn::make('date')->label(__('trans.date.text')),
                TextColumn::make('other')->label(__('trans.other.text')),
                TextColumn::make('forerunner')->label(__('trans.forerunner.text')),
                TextColumn::make('financial')->label(__('trans.financial.text')),
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
