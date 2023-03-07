<?php

namespace App\Filament\Resources;

use App\Models\CarReceive;
use App\Models\EmployeeHistory;
use App\Models\Invoice;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use App\Models\EmployeeRequisition;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EmployeeRequisitionResource\Pages;
use App\Filament\Resources\EmployeeRequisitionResource\RelationManagers;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;

class EmployeeRequisitionResource extends Resource
{
    protected static ?string $model = EmployeeRequisition::class;
    protected static ?string $navigationGroup = 'การเงิน';
    protected static ?string $navigationLabel = 'ใบเบิกเงินพนักงาน';
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $pluralLabel = 'ใบเบิกเงินพนักงาน';

    public static function form(Form $form): Form
    {
        $employeeList = EmployeeHistory::query()
            ->orderBy('name_surname', 'desc')
            ->get('name_surname')
            ->pluck('name_surname', 'name_surname')
            ->toArray();
        $employeeCode = EmployeeHistory::query()
        ->orderBy('employee_code', 'desc')
        ->get('employee_code')
        ->pluck('employee_code', 'employee_code')
        ->toArray();

        return $form
            ->schema([
                DatePicker::make('input')
                ->label(__('trans.input.text'))
                ->required()
                ->default(now()->format('Y-m-d')),
                Card::make()
                ->schema([
                    Placeholder::make('รายการเบิกเงินพนักงาน'),
                    Repeater::make('employeerequisitionitems')
                    ->relationship()
                    ->schema(
                        [

                            Select::make('employee_lists')
                                ->label(' ' . __('trans.employee_lists.text'))
                                ->preload()
                                ->required()
                                ->searchable()
                                ->options($employeeList)
                                ->reactive()
                                ->columnSpan([
                                    'md' => 4,
                                ])
                                ->afterStateUpdated(function ($set, $state) {
                                    if ($state) {
                                        $employee = EmployeeHistory::query()->where('name_surname', $state)->first();
                                        if ($employee) {
                                            $employee = $employee->toArray();
                                            $set('order', $employee['employee_code']);
                                        }
                                    }
                                }),
                            TextInput::make('disbursement_amount')->label(__('trans.disbursement_amount.text'))
                            ->columnSpan([
                                'md' => 3,
                            ])->required(),
                        ])
                    ->defaultItems(count: 1)
                    ->columns([
                        'md' => 7,
                    ]) ->createItemButtonLabel('เพิ่มรายการเบิกเงินพนักงาน'),

                ])->columnSpan('full'),
                TextInput::make('courier_document')
                ->label(__('trans.courier_document.text'))
                ->required(),
                TextInput::make('approver')
                ->label(__('trans.approver.text'))
                ->required(),
                SpatieMediaLibraryFileUpload::make('other_files')
                    ->multiple()
                    ->label(__('trans.other_files.text'))
                    ->image()
                    ->enableDownload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('input')->label(__('trans.input.text'))->searchable(),
                TextColumn::make('courier_document')->label(__('trans.courier_document.text')),
                TextColumn::make('approver')->label(__('trans.approver.text')),
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
                Tables\Actions\DeleteAction::make()
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
            'index' => Pages\ListEmployeeRequisitions::route('/'),
            'create' => Pages\CreateEmployeeRequisition::route('/create'),
            'edit' => Pages\EditEmployeeRequisition::route('/{record}/edit'),
        ];
    }
}
