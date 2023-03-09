<?php

namespace App\Filament\Resources;

use App\Filament\Traits\JobNumberTrait;
use App\Models\Customer;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables;
use App\Models\CarReceive;
use Illuminate\Support\Arr;
use Filament\Resources\Form;
use App\Models\PurchaseOrder;
use Filament\Resources\Table;
use Filament\Facades\Filament;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use App\Filament\Resources\PurchaseOrderResource\Pages;
use App\Filament\Resources\PurchaseOrderResource\RelationManagers;
use Illuminate\Support\Facades\Config;

class PurchaseOrderResource extends Resource
{
    use JobNumberTrait;

    protected static ?string $model = PurchaseOrder::class;
    protected static ?string $navigationGroup = 'บัญชี';
    protected static ?string $navigationLabel = 'ใบคำสั่งซื้อ';
    protected static ?string $navigationIcon = 'heroicon-o-save-as';
    protected static ?string $pluralLabel = 'ใบคำสั่งซื้อ';

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
                                $set('vehicle_registration', $carReceive['vehicle_registration']);
                                $set('customer', $carReceive['customer']);
                                $set('insu_company_name', $carReceive['insu_company_name']);
                                $set('model', $carReceive['model']);
                                $set('car_year', $carReceive['car_year']);
                            }
                        }
                    })
                ),
                TextInput::make('vehicle_registration')
                    ->required()
                    ->disabled()
                    ->label(__('trans.vehicle_registration.text')),
                TextInput::make('model')
                    ->required()
                    ->disabled()
                    ->label(__('trans.model.text')),
                TextInput::make('car_year')
                    ->required()
                    ->disabled()
                    ->label(__('trans.car_year.text')),
                Select::make('store')
                    ->label(__('trans.store.text'))
                    ->required()
                    ->preload()
                    ->searchable()
                    ->options(function () {
                        return Customer::query()
                            ->get('store')
                            ->pluck('store', 'store')
                            ->toArray();
                    }),
                TextInput::make('parts_list_total')
                    ->required()
                    ->label(__('trans.parts_list_total.text')),
                Card::make()
                    ->columnSpan('full')
                    ->schema(
                        [
                            Placeholder::make('รายการอะไหล่'),
                            Repeater::make('purchaseorderitems')
                                ->relationship()
                                ->defaultItems(count: 1)
                                ->columns([ 'md' => 12 ])
                                ->createItemButtonLabel('เพิ่มรายการอะไหล่')
                                ->schema(
                                    [
                                        Select::make('code_c0_c7')
                                            ->label(__('trans.code_c0_c7.text'))
                                            ->options(Config::get('static.code-c0-c7'))
                                            ->required()
                                            ->reactive()
                                            ->columnSpan(['md' => 2]),

                                        TextInput::make('parts_list')
                                            ->label(__('trans.parts_list.text'))
                                            ->columnSpan(['md' => 3])
                                            ->required(),
                                        TextInput::make('price')
                                            ->label(__('trans.price.text'))
                                            ->numeric()
                                            ->columnSpan(['md' => 2])
                                            ->required(),
                                        TextInput::make('quantity')
                                            ->label(__('trans.quantity.text'))
                                            ->numeric()
                                            ->reactive()
                                            ->columnSpan(['md' => 1])
                                            ->required(),
                                        TextInput::make('vat')
                                            ->label(__('trans.vat.text'))
                                            ->numeric()
                                            ->reactive()
                                            ->columnSpan(['md' => 2])
                                            ->required()
                                            ->disabled()
                                            ->placeholder(function (Closure $get, Closure $set) {
                                                $quantity = $get('quantity') ? $get('quantity') : 1;
                                                $price = $get('price') ? $get('price') : 0;
                                                $total = $price * $quantity;
                                                $totalVat = $total * (7/100);
                                                $result = $totalVat ? number_format(str_replace(',', '', $totalVat), 2) : '0.00';
                                                $set('vat', $result);

                                                return $result;
                                            }),
                                        TextInput::make('aggregate_price_tmp')
                                            ->label(__('trans.aggregate_price.text'))
                                            ->columnSpan(['md' => 2])
                                            ->disabled()
                                            ->placeholder(function (Closure $get, Closure $set) {
                                                $quantity = $get('quantity') ? $get('quantity') : 1;
                                                $price = $get('price') ? $get('price') : 0;
                                                $total = $price * $quantity;
                                                $vat = $total * (7/100);
                                                $totalPrice = $total + $vat;
                                                $result = $totalPrice ? number_format($totalPrice, 2) : '0.00';
                                                $set('aggregate_price', $result);

                                                return $result;
                                            }),
                                    ]
                                ),
                        ]
                    ),
                TextInput::make('note')
                    ->label(__('trans.note.text'))
                    ->required(),
                TextInput::make('buyer')
                    ->label(__('ผู้สั่งซื้อ'))
                    ->required(),
                TextInput::make('approver')
                    ->label('ผู้อนุมัติ')
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
                TextColumn::make('job_number')->label(__('trans.job_number.text'))->searchable(),
                TextColumn::make('vehicle_registration')->label(__('trans.vehicle_registration.text'))->searchable(),
                TextColumn::make('model')->label(__('trans.model.text')),
                TextColumn::make('car_year')->label(__('trans.car_year.text')),
                TextColumn::make('store')->label(__('trans.store.text')),
                TextColumn::make('parts_list_total')->label(__('trans.parts_list_total.text')),
                TextColumn::make('vat')
                    ->label(__('trans.vat.text'))
                    ->alignEnd()
                    ->formatStateUsing(fn (?string $state): string => number_format(floatval(str_replace(',', '', $state)), 2)),
                TextColumn::make('aggregate_price')
                    ->label(__('trans.aggregate_price.text'))
                    ->alignEnd()
                    ->formatStateUsing(fn (?string $state): string => number_format(floatval(str_replace(',', '', $state)), 2)),
                TextColumn::make('note')->label(__('trans.note.text')),
                TextColumn::make('buyer')->label(__('ผู้สั่งซื้อ')),
                TextColumn::make('approver')->label('ผู้อนุมัติ'),
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
                Tables\Actions\DeleteAction::make()->disabled(Filament::auth()->user()->email !== 'super@admin.com'),
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
            'index' => Pages\ListPurchaseOrders::route('/'),
            'create' => Pages\CreatePurchaseOrder::route('/create'),
            'edit' => Pages\EditPurchaseOrder::route('/{record}/edit'),
        ];
    }
}
