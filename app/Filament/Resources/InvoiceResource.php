<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables;
use App\Models\Invoice;
use App\Models\CarReceive;
use Illuminate\Support\Arr;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Facades\Filament;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use App\Filament\Resources\InvoiceResource\Pages;
use App\Filament\Resources\InvoiceResource\RelationManagers;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;
    protected static ?string $navigationGroup = 'บัญชี';
    protected static ?string $navigationLabel = 'ใบแจ้งหนี้';
    protected static ?string $navigationIcon = 'heroicon-o-document-add';
    protected static ?string $pluralLabel = 'ใบแจ้งหนี้';

    public static function getViewData(): array{
        $currentGarage =  Filament::auth()->user()->garage;
        $optionData = CarReceive::query()
            ->where('choose_garage', $currentGarage)
            ->orderBy('job_number', 'desc')
            ->get('job_number')
            ->pluck('job_number', 'job_number')
            ->toArray();
        $optionValue = [];

        if (!$optionData) {
            $jobNumberFirst = $currentGarage . now()->format('-y-m-d-') . '0001';
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

                $lastValue = $currentGarage . now()->format('-y-m-d-') . $lastValue;
                $optionValue[$lastValue] = $lastValue;
            }

            foreach ($optionData as $val) {
                $optionValue[$val] = $val;
            }
        }

        return [
            Select::make('job_number')
                ->label(' ' . __('trans.job_number.text') . ' ' . __('trans.current_garage.text') . $currentGarage)
                ->preload()
                ->required()
                ->searchable()
                ->options($optionData)
                ->reactive()
                ->afterStateUpdated(function ($set, $state) {
                    if ($state) {
                        $name = CarReceive::query()->where('job_number', $state)->first();
                        if ($name) {
                            $name = $name->toArray();
                            $set('vehicle_registration', $name['vehicle_registration']);
                            $set('customer', $name['customer']);
                            $set('brand', $name['brand']);
                            $set('insu_company_name', $name['insu_company_name']);
                        }
                    }
                }),
        ];
    }

    public static function getINVdata(): array
    {
        $currentGarage =  Filament::auth()->user()->garage;
        $optionData = Invoice::query()
            ->where('choose_garage', $currentGarage)
            ->orderBy('invoice_number', 'desc')
            ->get('invoice_number')
            ->pluck('invoice_number', 'invoice_number')
            ->toArray();
        $optionValue = [];

        if (!$optionData) {
            $INVFirst = 'INV' . now()->format('-y-m-d-') . '00001';
            $optionValue[$INVFirst] = $INVFirst;
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

                $lastValue = 'INV' . now()->format('-y-m-d-') . $lastValue;
                $optionValue[$lastValue] = $lastValue;
            }

            foreach ($optionData as $val) {
                $optionValue[$val] = $val;
            }
        }

        return[
            Select::make('invoice_number')
                ->label(__('trans.invoice_number.text'))
                ->preload()
                ->required()
                ->searchable()
                ->options($optionValue)
                ->afterStateUpdated(function ($set, $state) {
                    $set('choose_garage', Filament::auth()->user()->garage);
                    $set('invoice_number', $state);
                    $set('recipient_document', Filament::auth()->user()->name);
                    $set('courier_document', Filament::auth()->user()->name);
                })
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('choose_garage'),
                Card::make()->schema(static::getViewData('job_number')),
                Card::make()->schema(static::getINVdata('invoice_number')),
                TextInput::make('customer')
                    ->label(__('trans.customer.text'))
                    ->required()
                    ->disabled(),
                TextInput::make('insu_company_name')
                    ->label(__('trans.insu_company_name.text'))
                    ->disabled(),
                TextInput::make('brand')
                    ->label(__('trans.brand.text'))
                    ->disabled()
                    ->columns(65),
                TextInput::make('vehicle_registration')
                    ->label(__('trans.vehicle_registration.text'))
                    ->required()
                    ->disabled(),
                Card::make()
                    ->schema([
                        Placeholder::make('รายการค่าใช้จ่าย'),
                        Repeater::make('invoiceItems')
                            ->reactive()
                            ->relationship()
                            ->schema(
                                [
                                    Hidden::make('job_number'),
                                    Hidden::make('code_c0_c7'),
                                    TextInput::make('spare_code')
                                        ->label(__('trans.items.text'))
                                        ->columnSpan([
                                            'md' => 5,
                                        ])
                                        ->required(),
                                    TextInput::make('price')
                                        ->label(__('trans.amount.text'))
                                        ->numeric()
                                        ->columnSpan([
                                            'md' => 3,
                                        ])
                                        ->required(),
                                ]
                            )
                            ->defaultItems(count: 1)
                            ->columns(['md' => 8,])
                            ->createItemButtonLabel('เพิ่มรายการค่าใช้จ่าย'),
                        ])
                    ->columnSpan('full'),
                TextInput::make('amount_display')
                    ->label(__('trans.amount.text'))
                    ->disabled()
                    ->placeholder(function (Closure $get) {
                        $invoiceItems = $get('invoiceItems');
                        $total = 0;

                        foreach ($invoiceItems as $item) {
                            if(Arr::get($item, 'price')) {
                                $total += Arr::get($item, 'price');
                            }
                        }

                        return $total ? number_format($total, 2) : '0.00';
                    }),
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
                    ->placeholder(function (Closure $get) {
                        $invoiceItems = $get('invoiceItems');
                        $chooseVat = $get('choose_vat_or_not');
                        $vat = 0;
                        $total = 0;

                        foreach ($invoiceItems as $item) {
                            if(Arr::get($item, 'price')) {
                                $total += Arr::get($item, 'price');
                            }
                        }

                        if ($chooseVat == 'vat_include_yes') {
                            $vat = $total * (7/100);
                        }
                        return $vat ? number_format($vat, 2) : '0.00';
                    }),
                TextInput::make('aggregate_display')
                    ->label(__('trans.aggregate.text'))
                    ->disabled()
                    ->placeholder(function (Closure $get) {
                        $invoiceItems = $get('invoiceItems');
                        $total = 0;
                        $vatTotal = 0;
                        $aggregate = 0;

                        foreach ($invoiceItems as $item) {
                            if(Arr::get($item, 'price')) {
                                $total += Arr::get($item, 'price');
                            }
                        }

                        if ($get('choose_vat_or_not') == 'vat_include_yes') {
                            $vatTotal = $total * (7/100);
                        }

                        return $vatTotal+ $total;
                    }),
                ViewField::make('courier_document_display')->view('filament.resources.forms.components.sender-document'),
                TextInput::make('biller')->label('ผู้วางบิล')->required(),
                TextInput::make('bill_payer')->label('ผู้รับวางบิล(ลูกค้า)')->required(),
                Hidden::make('recipient_document'),
                Hidden::make('courier_document'),
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
                TextColumn::make('job_number')
                    ->label(__('trans.job_number.text'))
                    ->searchable(),
                TextColumn::make('invoice_number')->label(__('trans.invoice_number.text')),
                TextColumn::make('customer')->label(__('trans.customer.text')),
                TextColumn::make('vehicle_registration')
                    ->label(__('trans.vehicle_registration.text'))
                    ->searchable(),
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
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }
}
