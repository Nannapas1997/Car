<?php

namespace App\Filament\Resources;

use App\Filament\Traits\JobNumberTrait;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables;
use App\Models\CarReceive;
use Filament\Resources\Form;
use Filament\Resources\Table;
use App\Models\SaveRepairCost;
use Filament\Facades\Filament;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use App\Filament\Resources\SaveRepairCostResource\Pages;
use App\Filament\Resources\SaveRepairCostResource\RelationManagers;
use Filament\Forms\Components\ViewField;
use Illuminate\Support\Facades\Config;

class SaveRepairCostResource extends Resource
{
    use JobNumberTrait;

    protected static ?string $model = SaveRepairCost::class;
    protected static ?string $navigationGroup = 'บัญชี';
    protected static ?string $navigationLabel = 'ต้นทุนค่าแรง';
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $pluralLabel = 'ต้นทุนค่าแรง';

    public static function form(Form $form): Form
    {
        $currentGarage =  Filament::auth()->user()->garage;

        return $form
            ->schema([
                Card::make()->schema(
                    static::getViewData($currentGarage, function ($set, $state) use ($currentGarage) {
                        if ($state) {
                            $carReceive = CarReceive::query()->where('job_number', $state)->first();
                            if ($carReceive) {
                                $carReceive = $carReceive->toArray();
                                $set('model', $carReceive['model']);
                                $set('car_year', $carReceive['car_year']);
                                $set('customer', $carReceive['customer']);
                                $set('insu_company_name', $carReceive['insu_company_name']);
                                $set('vehicle_registration', $carReceive['vehicle_registration']);
                                $set('brand', $carReceive['brand']);
                            }
                        }
                    })
                ),
                Fieldset::make('ข้อมูลเจ้าของรถ')
                    ->schema(
                        [
                            TextInput::make('customer')
                                ->label(__('trans.customer.text'))
                                ->required()
                                ->disabled(),
                            TextInput::make('vehicle_registration')
                                ->label(__('trans.vehicle_registration.text'))
                                ->required()
                                ->disabled(),
                            Select::make('brand')
                                ->label(__('trans.brand.text'))
                                ->required()
                                ->disabled()
                                ->options(Config::get('static.car-brand'))
                                ->columns(65),
                            TextInput::make('model')
                                ->label(__('trans.model.text'))
                                ->required()
                                ->disabled(),
                            Select::make('car_year')
                                ->label(__('trans.car_year.text'))
                                ->preload()
                                ->required()
                                ->searchable()
                                ->disabled()
                                ->options(helperGetYearList()),
                        ]
                    ),
                Fieldset::make('ข้อมูลร้านค้า')
                    ->schema(
                        [
                            Select::make('store')
                                ->label(__('trans.store.text'))
                                ->required()
                                ->preload()
                                ->options([
                                    'ร้านA'=>'ร้านA',
                                    'ร้านB'=>'ร้านB',
                                    'ร้านC'=>'ร้านC',
                                    'ร้านD'=>'ร้านD',
                                ]),
                            TextInput::make('address')
                                ->label(__('trans.address.text'))
                                ->required(),
                            TextInput::make('taxpayer_number')
                                ->label('เลขที่ประจำตัวผู้เสียภาษี')
                                ->required(),
                            TextInput::make('contact_name')
                                ->label('ชื่อผู้ติดต่อ')
                                ->required(),
                            TextInput::make('tel_number')
                                ->label('เบอร์โทร')
                                ->required()
                        ]
                    ),
                Card::make()
                    ->columnSpan('full')
                    ->schema(
                        [
                            Placeholder::make('รายการค่าใช้จ่าย'),
                            Repeater::make('saveRepairCostItems')
                                ->relationship()
                                ->schema(
                                    [
                                        Select::make('code_c0_c7')->label(__('trans.code_c0_c7.text'))
                                        ->options(Config::get('static.code-c0-c7'))
                                        ->required()
                                        ->reactive()
                                        ->columnSpan(['md' => 2]),
                                        TextInput::make('price')
                                            ->label(__('trans.price.text'))
                                            ->numeric()
                                            ->reactive()
                                            ->columnSpan(['md' => 3])
                                            ->required(),
                                        TextInput::make('spare_code')
                                            ->label(__('trans.spare_code.text'))
                                            ->columnSpan(['md' => 3])
                                            ->required(),
                                    ]
                                )
                                ->defaultItems(count: 1)
                                ->columns(['md' => 8])
                                ->createItemButtonLabel('เพิ่มรายการค่าใช้จ่าย'),
                        ]
                    ),
                TextInput::make('total')
                    ->label(__('trans.total.text'))
                    ->disabled()
                    ->placeholder(function (Closure $get) {
                        return calTotalItems(
                            $get('saveRepairCostItems'),
                            'price',
                            'vat_include_no'
                        );
                    }),
                SpatieMediaLibraryFileUpload::make('other_files')
                    ->multiple()
                    ->label(__('trans.other_files.text'))
                    ->image()
                    ->enableDownload(),
                ViewField::make('courier_document')
                    ->view('filament.resources.forms.components.courier_document')
                    ->required(),
                TextInput::make('approver')
                    ->label(__('trans.approver.text'))
                    ->required()
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('job_number')->label(__('trans.job_number.text'))->searchable(),
                TextColumn::make('vehicle_registration')->label(__('trans.vehicle_registration.text'))->searchable(),
                TextColumn::make('customer')->label(__('trans.customer.text')),
                TextColumn::make('vehicle_registration')->label(__('trans.vehicle_registration.text')),
                TextColumn::make('brand')->label(__('trans.brand.text')),
                TextColumn::make('model')->label(__('trans.model.text')),
                TextColumn::make('car_year')->label(__('trans.car_year.text')),
                TextColumn::make('total')
                    ->label(__('trans.total.text'))
                    ->alignEnd()
                    ->formatStateUsing(fn (?string $state): string => number_format($state, 2)),
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
