<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use App\Models\EmployeeHistory;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EmployeeHistoryResource\Pages;
use App\Filament\Resources\EmployeeHistoryResource\RelationManagers;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;

class EmployeeHistoryResource extends Resource
{
    protected static ?string $model = EmployeeHistory::class;
    protected static ?string $navigationGroup = 'History';
    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('employee_code')
                ->label(__('trans.employee_code.text'))
                ->required(),
                Select::make('prefix')
                ->label(__('trans.prefix.text'))
                ->required()
                ->searchable()
                ->preload()
                ->options([
                    'นาย' => 'นาย',
                    'นาง' => 'นาง',
                    'นางสาว' => 'นางสาว'
                ]),
                TextInput::make('name_surname')
                ->label(__('trans.name_surname.text'))
                ->required(),
                DatePicker::make('birthdate')
                ->label(__('trans.birthdate.text'))
                ->required(),
                TextInput::make('id_card')
                ->label(__('trans.id_card.text'))
                ->required(),
                TextInput::make('nationality')
                ->label(__('trans.nationality.text'))
                ->required(),
                Textarea::make('address')
                ->label(__('trans.address.text'))
                ->required(),
                TextInput::make('tel_number')
                ->label(__('trans.tel_number.text'))
                ->required(),
                TextInput::make('email')
                ->label(__('trans.email.text'))
                ->required(),
                DatePicker::make('start_work_date')
                ->label(__('trans.start_work_date.text'))
                ->required(),
                TextInput::make('field')
                ->label(__('trans.field.text'))
                ->required(),
                TextInput::make('technician_team')
                ->label(__('trans.technician_team.text'))
                ->required(),
                TextInput::make('under_the_cradle')
                ->label(__('trans.under_the_cradle.text'))
                ->required(),
                TextInput::make('salary')
                ->label(__('trans.salary.text'))
                ->required(),
                TextInput::make('other_money')
                ->label(__('trans.other_money.text'))
                ->required(),
                DatePicker::make('employee_termination_date')
                ->label(__('trans.employee_termination_date.text')),
                TextInput::make('cause')
                ->label(__('trans.cause.text'))
                ->required(),
                FileUpload::make('resignation_document')
                ->label(__('trans.resignation_document.text'))
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee_code')->label(__('trans.employee_code.text')),
                TextColumn::make('prefix')->label(__('trans.prefix.text')),
                TextColumn::make('name_surname')->label(__('trans.name_surname.text')),
                TextColumn::make('birthdate')->label(__('trans.birthdate.text')),
                TextColumn::make('id_card')->label(__('trans.id_card.text')),
                TextColumn::make('nationality')->label(__('trans.nationality.text')),
                TextColumn::make('address')->label(__('trans.address.text')),
                TextColumn::make('tel_number')->label(__('trans.tel_number.text')),
                TextColumn::make('email')->label(__('trans.email.text')),
                TextColumn::make('start_work_date')->label(__('trans.start_work_date.text')),
                TextColumn::make('field')->label(__('trans.field.text')),
                TextColumn::make('technician_team')->label(__('trans.technician_team.text')),
                TextColumn::make('under_the_cradle')->label(__('trans.under_the_cradle.text')),
                TextColumn::make('salary')->label(__('trans.salary.text')),
                TextColumn::make('other_money')->label(__('trans.other_money.text')),
                TextColumn::make('employee_termination_date')->label(__('trans.employee_termination_date.text')),
                TextColumn::make('cause')->label(__('trans.cause.text')),
                TextColumn::make('resignation_document')->label(__('trans.resignation_document.text')),
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
            'index' => Pages\ListEmployeeHistories::route('/'),
            'create' => Pages\CreateEmployeeHistory::route('/create'),
            'edit' => Pages\EditEmployeeHistory::route('/{record}/edit'),
        ];
    }
}
