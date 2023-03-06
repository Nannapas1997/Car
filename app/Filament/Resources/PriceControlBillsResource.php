<?php

namespace App\Filament\Resources;

use App\Filament\Traits\JobNumberTrait;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables;
use App\Models\CarReceive;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Facades\Filament;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use App\Models\PriceControlBills;
use Filament\Forms\Components\Card;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PriceControlBillsResource\Pages;
use App\Filament\Resources\PriceControlBillsResource\RelationManagers;

class PriceControlBillsResource extends Resource
{
    use JobNumberTrait;

    protected static ?string $model = PriceControlBills::class;
    protected static ?string $navigationGroup = 'บัญชี';
    protected static ?string $navigationLabel = 'ใบคุมราคา';
    protected static ?string $navigationIcon = 'heroicon-o-receipt-tax';
    protected static ?string $pluralLabel = 'ใบคุมราคา';

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
                                $set('noti_number', $carReceive['noti_number']);
                                $set('number_ab', $carReceive['number_ab']);
                            }
                        }
                    })
                ),
                TextInput::make('number_price_control')
                    ->label(__('trans.number_price_control.text')),
                TextInput::make('noti_number')
                    ->label(__('trans.noti_number.text'))
                    ->required()
                    ->disabled(),
                TextInput::make('number_ab')
                    ->label(__('trans.number_ab.text'))
                    ->required(),
                TextInput::make('customer')
                    ->label(__('trans.customer.text'))
                    ->required()
                    ->disabled()
                    ->disabled(),
                TextInput::make('vehicle_registration')
                    ->label(__('trans.vehicle_registration.text'))
                    ->required()
                    ->disabled(),
                TextInput::make('insu_company_name')
                    ->label(__('trans.insu_company_name.text'))
                    ->required()
                    ->disabled(),
                TextInput::make('labor_price')
                    ->label('ราคาค่าแรงที่เสนอ')
                    ->required(),
                TextInput::make('price_offer')
                    ->label('ราคาค่าอะไหล่ที่เสนอ')
                    ->required(),
                TextInput::make('wage_stop')
                    ->label('ราคาค่าอะไหล่ที่ยุติ')
                    ->required(),
                TextInput::make('price_spare_parts')
                    ->label('ราคาค่าแรงที่ยุติ')
                    ->required(),
                TextInput::make('termination_price')
                    ->label(__('trans.termination_price.text'))
                    ->numeric()
                    ->required(),
                TextInput::make('note')
                    ->label(__('trans.note.text'))
                    ->required(),
                TextInput::make('courier')
                    ->label(__('trans.courier.text'))
                    ->required(),
                TextInput::make('price_dealer')
                    ->label(__('trans.price_dealer.text'))
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
                TextColumn::make('job_number_control')->label(__('trans.job_number.text'))->searchable(),
                TextColumn::make('number_price_control')->label(__('trans.number_price_control.text')),
                TextColumn::make('noti_number')->label(__('trans.noti_number.text')),
                TextColumn::make('number_ab')->label(__('trans.number_ab.text')),
                TextColumn::make('customer')->label(__('trans.customer.text')),
                TextColumn::make('vehicle_registration')->label(__('trans.vehicle_registration.text'))->searchable(),
                TextColumn::make('insu_company_name')->label(__('trans.insu_company_name.text')),
                TextColumn::make('termination_price')->label(__('trans.termination_price.text')),
                TextColumn::make('note')->label(__('trans.note.text')),
                TextColumn::make('courier')->label(__('trans.courier.text')),
                TextColumn::make('price_dealer')->label(__('trans.price_dealer.text')),
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
                Tables\Actions\DeleteAction::make(),
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
