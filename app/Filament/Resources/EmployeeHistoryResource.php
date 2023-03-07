<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables;
use App\Models\CarReceive;
use Illuminate\Support\Arr;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Facades\Filament;
use Illuminate\Support\Carbon;
use App\Models\EmployeeHistory;
use App\Models\ThailandAddress;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EmployeeHistoryResource\Pages;
use App\Filament\Resources\EmployeeHistoryResource\RelationManagers;

class EmployeeHistoryResource extends Resource
{
    protected static ?string $model = EmployeeHistory::class;
    protected static ?string $navigationGroup = 'ประวัติ';
    protected static ?string $navigationLabel = 'ประวัติพนักงาน';
    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $pluralLabel = 'ประวัติพนักงาน';

    public static function getViewData(): array{
        $currentGarage =  Filament::auth()->user()->garage;
        $optionData = EmployeeHistory::query()
            ->orderBy('employee_code', 'desc')
            ->get('employee_code')
            ->pluck('employee_code', 'employee_code')
            ->toArray();
        $optionValue = [];

        if (!$optionData) {
            $employeeCodeFirst = 'R-'. '00001';
            $optionValue[$employeeCodeFirst] = $employeeCodeFirst;
        } else {
            $lastValue = Arr::first($optionData);

            if ($lastValue) {
                $lastValueExplode = explode('-', $lastValue);
                $lastValue = intval($lastValueExplode[count($lastValueExplode)-1]);
                $lastValue += 1;
                $lastValue = $lastValue < 10 ? "0000{$lastValue}" :
                    ($lastValue < 100 ? "000{$lastValue}" :
                        ($lastValue < 1000 ? "00{$lastValue}" :
                            ($lastValue < 10000 ? "0{$lastValue}" : $lastValue)));

                $lastValue = 'R-'. $lastValue;
                $optionValue[$lastValue] = $lastValue;
            }

            foreach ($optionData as $val) {
                $optionValue[$val] = $val;
            }
        }

        return [
            Select::make('employee_code')
                ->label(' ' . __('trans.employee_code.text'))
                ->preload()
                ->required()
                ->searchable()
                ->options($optionValue)
                ->afterStateUpdated(function (Closure $set, $state) {
                    $bill = EmployeeHistory::query()->where('employee_code', $state)->first();
                    if ($bill) {
                        $bill = $bill->toArray();
                    }
                }),
        ];
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema(static::getViewData('employee_code')),
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
                Fieldset::make('ที่อยู่พนักงาน')
                    ->schema([
                        TextInput::make('address')->label(__('trans.address.text'))->required()->columnSpanFull(),
                        Select::make('postal_code')
                            ->label(__('trans.postal_code.text'))
                            ->required()
                            ->preload()
                            ->searchable()
                            ->reactive()
                            ->options(function (Closure $get) {
                                $displayAddress = [];
                                $address = ThailandAddress::where('zipcode', 'like', '%' . $get('postal_code') . '%')
                                    ->get()
                                    ->toArray();

                                if ($address) {
                                    foreach ($address as $val) {
                                        $displayAddress[Arr::get($val, 'id')] = Arr::get($val, 'zipcode')
                                            . ' '
                                            . Arr::get($val, 'district')
                                            . ' '
                                            . Arr::get($val, 'amphoe')
                                            . ' '
                                            . Arr::get($val, 'province');
                                    }
                                }

                                return $displayAddress;
                            })
                            ->afterStateUpdated(function ($set, $state) {
                                if ($state) {
                                    $name = ThailandAddress::find($state)->toArray();
                                    if ($name) {
                                        $set('district', $name['district']);
                                        $set('amphoe', $name['amphoe']);
                                        $set('province', $name['province']);
                                    }
                                }
                            }),
                         TextInput::make('district')->label(__('trans.district.text'))->required(),
                         TextInput::make('amphoe')->label(__('trans.amphoe.text'))->required(),
                         TextInput::make('province')->label(__('trans.province.text'))->required(),
                    ]),
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
                ->label(__('trans.cause.text')),
                FileUpload::make('resignation_document')
                ->label(__('trans.resignation_document.text')),
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
                TextColumn::make('employee_code')->label(__('trans.employee_code.text'))->searchable(),
                TextColumn::make('prefix')->label(__('trans.prefix.text')),
                TextColumn::make('name_surname')->label(__('trans.name_surname.text')),
                TextColumn::make('birthdate')->label(__('trans.birthdate.text')),
                TextColumn::make('id_card')->label(__('trans.id_card.text'))->searchable(),
                TextColumn::make('nationality')->label(__('trans.nationality.text')),
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
            'index' => Pages\ListEmployeeHistories::route('/'),
            'create' => Pages\CreateEmployeeHistory::route('/create'),
            'edit' => Pages\EditEmployeeHistory::route('/{record}/edit'),
        ];
    }
}
