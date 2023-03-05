<?php

namespace App\Filament\Resources;

use App\Filament\Traits\JobNumberTrait;
use Closure;
use App\Models\Bill;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Arr;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Facades\Filament;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\BillResource\Pages;
use App\Filament\Resources\BillResource\RelationManagers;
use Illuminate\Support\Facades\Config;

class BillResource extends Resource
{
    use JobNumberTrait;

    protected static ?string $model = Bill::class;
    protected static ?string $navigationGroup = 'บัญชี';
    protected static ?string $navigationLabel = 'ใบวางบิล';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $pluralLabel = 'ใบวางบิล';

    public static function getBillData(): array
    {
        $currentGarage =  Filament::auth()->user()->garage;
        $optionData = Bill::query()
            ->where('choose_garage', $currentGarage)
            ->orderBy('bill_number', 'desc')
            ->get('bill_number')
            ->pluck('bill_number', 'bill_number')
            ->toArray();
        $optionValue = [];

        if (!$optionData) {
            $jobNumberFirst = 'B' . now()->format('-y-m-d-') . '00001';
            $optionValue[$jobNumberFirst] = $jobNumberFirst;
        } else {
            $lastValue = Arr::first($optionData);

            if ($lastValue) {
                $lastValueExplode = explode('-', $lastValue);
                $lastValue = intval($lastValueExplode[count($lastValueExplode) - 1]);
                $lastValue += 1;
                $lastValue = $lastValue < 10 ? "0000{$lastValue}" :
                    ($lastValue < 100 ? "000{$lastValue}" :
                        ($lastValue < 1000 ? "00{$lastValue}" :
                            ($lastValue < 10000 ? "0{$lastValue}" : $lastValue)));

                $lastValue = 'B' . now()->format('-y-m-d-') . $lastValue;
                $optionValue[$lastValue] = $lastValue;
            }

            foreach ($optionData as $val) {
                $optionValue[$val] = $val;
            }
        }

        return [
            Select::make('bill_number')
                ->label('เลขที่ใบวางบิล')
                ->preload()
                ->required()
                ->searchable()
                ->options($optionValue)
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('choose_garage'),
                Card::make()->schema(static::getViewData()),
                Card::make()->schema(static::getBillData()),
                TextInput::make('customer')
                    ->label(__('trans.customer.text'))
                    ->required()
                    ->disabled(),
                TextInput::make('vehicle_registration')
                    ->label(__('trans.vehicle_registration.text'))
                    ->required()
                    ->disabled(),
                TextInput::make('invoice_number')
                    ->label(__('trans.invoice_number.text'))
                    ->required(),
                TextInput::make('amount')
                    ->label(__('trans.amount.text'))
                    ->numeric()
                    ->reactive()
                    ->required(),
                Radio::make('choose_vat_or_not')
                    ->columnSpanFull()
                    ->label('ระบุตัวเลือกที่ต้องการ')
                    ->reactive()
                    ->required()
                    ->options(Config::get('static.include-vat-options'))
                    ->default('vat_include_yes'),
                TextInput::make('vat_display')
                    ->label(__('trans.vat.text'))
                    ->disabled()
                    ->placeholder(fn (Closure $get) => calVat($get('amount'), $get('choose_vat_or_not'))),
                TextInput::make('aggregate_display')
                    ->label(__('trans.aggregate.text'))
                    ->disabled()
                    ->placeholder(fn (Closure $get) => calTotal($get('amount'), $get('choose_vat_or_not'))),
                TextInput::make('courier_document')
                    ->label(__('trans.courier_document.text'))
                    ->required(),
                TextInput::make('recipient_document')
                    ->label(__('trans.recipient_document.text'))
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
                TextColumn::make('bill_number')->label(__('trans.bill_number.text')),
                TextColumn::make('invoice_number')->label(__('trans.invoice_number.text')),
                TextColumn::make('customer')->label(__('trans.customer.text')),
                TextColumn::make('vehicle_registration')->label(__('trans.vehicle_registration.text'))->searchable(),
                TextColumn::make('amount')
                    ->label(__('trans.amount.text'))
                    ->alignEnd()
                    ->formatStateUsing(fn (?string $state): string => number_format($state, 2)),
                TextColumn::make('vat')
                    ->label(__('trans.vat.text'))
                    ->alignEnd(),
                TextColumn::make('aggregate')
                    ->label(__('trans.aggregate.text'))
                    ->alignEnd(),
                TextColumn::make('courier_document')->label(__('trans.courier_document.text')),
                TextColumn::make('recipient_document')->label(__('trans.recipient_document.text')),
            ])
            ->filters([
                Filter::make('created_at')
                ->form([
                    DatePicker::make('created_from')
                        ->placeholder(fn ($state): string => 'Dec 18, ' . now()->subYear()->format('Y')),
                    DatePicker::make('created_until')
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBills::route('/'),
            'create' => Pages\CreateBill::route('/create'),
            'edit' => Pages\EditBill::route('/{record}/edit'),
        ];
    }
}
