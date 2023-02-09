<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Quotation;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\QuotationResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\QuotationResource\RelationManagers;

class QuotationResource extends Resource
{
    protected static ?string $model = Quotation::class;
    protected static ?string $navigationGroup = 'My Work';
    protected static ?string $navigationIcon = 'heroicon-o-document-search';

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
                TextInput::make('customer')
                ->required()
                ->label(__('trans.customer.text')),
                Select::make('brand')
                ->required()
                ->label(__('trans.brand.text'))
                ->preload()
                ->options([
                    'Toyota' => 'Toyota',
                    'Honda' => 'Honda',
                    'Nissan' => 'Nissan',
                    'Mitsubishi'=>'Mitsubishi',
                    'Isuzu'=>'Isuzu',
                    'Mazda'=>'Mazda',
                    'Ford'=>'Ford',
                    'Suzuki'=>'Suzuki',
                    'Chevrolet'=>'Chevrolet',
                    'Alfa Romeo'=>'Alfo Romeo',
                    'Aston Martin'=>'Aston Martin',
                    'Audi'=>'Audi',
                    'Bentley'=>'Bentley',
                    'BMW'=>'BMW',
                    'Chery'=>'Chery',
                    'Chrysler'=>'Chrysler',
                    'Citroen'=>'Citroen',
                    'Daewoo'=>'Daewoo',
                    'Daihatsu'=>'Daihatsu',
                    'DFM'=>'DFM',
                    'DFSK'=>'DFSK',
                    'Ferrari'=>'Ferrari',
                    'Fiat'=>'Fiat',
                    'FOMM'=>'FOMM',
                    'Foton'=>'Foton',
                    'Great Wall Motor'=>'Great Wall Motor',
                    'Haval'=>'Haval',
                    'Holden'=>'Holden',
                    'Hummer'=>'Hummer',
                    'Hyundai'=>'Hyundai',
                    'Jaguar'=>'Jaguar',
                    'Jeep'=>'Jeep',
                    'Kia'=>'Kia',
                    'Lamborghini'=>'Lamborghini',
                    'Land Rover'=>'Land Rover',
                    'Lexus'=>'Lexus',
                    'Lotus'=>'Lotus',
                    'Maserati'=>'Maserati',
                    'Maxus'=>'Maxus',
                    'McLaren'=>'McLaren',
                    'Mercedes-Benz'=>'Mercedes-Benz',
                    'MG'=>'MG',
                    'Mini'=>'Mini',
                    'Mitsuoka'=>'Mitsuoka',
                    'Naza'=>'Naza',
                    'Opel'=>'Opel',
                    'ORA'=>'ORA',
                    'Peugeot'=>'Peugeot',
                    'Polarsun'=>'Polarsun',
                    'Porsche'=>'Porsche',
                    'Proton'=>'Proton',
                    'Rolls-Royce'=>'Rolls-Royce',
                    'Rover'=>'Rover',
                    'Saab'=>'Saab',
                    'Seat'=>'Seat',
                    'Skoda'=>'Skoda',
                    'Spyker'=>'Spyker',
                    'Ssangyong'=>'Ssangyong',
                    'Subaru'=>'Subaru',
                    'Tata'=>'Tata',
                    'Thairung'=>'Thairung',
                    'Volkswagen'=>'Volkswagen',
                    'Volvo'=>'Volvo',
                ])->columns(64),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('job_number')->label(__('trans.job_number.text'))->searchable(),
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
            'index' => Pages\ListQuotations::route('/'),
            'create' => Pages\CreateQuotation::route('/create'),
            'edit' => Pages\EditQuotation::route('/{record}/edit'),
        ];
    }
}
