<?php

namespace App\Filament\Resources;

use Closure;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use App\Models\Customer;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Traits\ThailandAddressTrait;
use App\Filament\Resources\CustomerResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CustomerResource\RelationManagers;

class CustomerResource extends Resource
{
    use ThailandAddressTrait;

    protected static ?string $model = Customer::class;

    protected static ?string $navigationGroup = 'งานของฉัน';
    protected static ?string $navigationLabel = 'จัดการร้านค้า';
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $pluralLabel = 'จัดการร้านค้า';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('store')->label(__('trans.store.text'))
                    ->required()
                    ->preload()
                    ->options([
                        'ร้านA'=>'ร้านA',
                        'ร้านB'=>'ร้านB',
                        'ร้านC'=>'ร้านC',
                        'ร้านD'=>'ร้านD',
                    ]),
                Fieldset::make('ที่อยู่ร้านค้า')
                    ->schema(
                        [
                            TextInput::make('address')
                                ->label(__('trans.address.text'))
                                ->required()
                                ->columnSpanFull(),
                            Select::make('postal_code')
                                ->label(__('trans.postal_code.text'))
                                ->required()
                                ->preload()
                                ->searchable()
                                ->reactive()
                                ->options(fn (Closure $get) => static::searchAddressOptions($get))
                                ->afterStateUpdated(
                                    fn ($set, $state) => static::setValueThailandAddress($set, $state)
                                ),
                            TextInput::make('district')
                                ->label(__('trans.district.text'))
                                ->required(),
                            TextInput::make('amphoe')
                                ->label(__('trans.amphoe.text'))
                                ->required(),
                            TextInput::make('province')
                                ->label(__('trans.province.text'))
                                ->required(),
                        ]
                ),
                TextInput::make('tel_number')
                    ->label(__('trans.tel_number.text'))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('store')
                    ->label(__('trans.store.text'))
                    ->searchable(),
                TextColumn::make('address')
                    ->label(__('trans.address.text')),
                TextColumn::make('postal_code')
                    ->label(__('trans.postal_code.text')),
                TextColumn::make('district')
                    ->label(__('trans.district.text')),
                TextColumn::make('amphoe')
                    ->label(__('trans.amphoe.text')),
                TextColumn::make('province')
                    ->label(__('trans.province.text')),
                TextColumn::make('tel_number')
                    ->label(__('trans.tel_number.text')),
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
