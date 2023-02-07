<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\CarReceive;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Illuminate\Support\Carbon;
use App\Models\ApprovalRequest;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ApprovalRequestResource\Pages;
use App\Filament\Resources\ApprovalRequestResource\RelationManagers;
use Filament\Forms\Components\TextInput;

class ApprovalRequestResource extends Resource
{
    protected static ?string $model = ApprovalRequest::class;
    protected static ?string $navigationGroup = 'Account';
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('job_number')
                ->label(__('trans.job_number.text'))
                ->preload()
                ->required()
                ->searchable()
                ->options([


                ]),
                TextInput::make('approval_number')
                ->label(__('trans.approval_number.text'))
                ->required(),
                TextInput::make('notification_number')
                ->label(__('trans.notification_number.text'))
                ->required(),
                TextInput::make('vehicle_registration')
                ->label(__('trans.vehicle_registration.text'))
                ->required(),
                TextInput::make('amount')
                ->label(__('trans.amount.text'))
                ->required(),
                TextInput::make('vat')
                ->label(__('trans.vat.text'))
                ->required(),
                TextInput::make('aggregate')
                ->label(__('trans.aggregate.text'))
                ->required(),
                TextInput::make('condition_value')
                ->label(__('trans.condition_value.text'))
                ->required(),
                Select::make('insu_company_name')
                ->label(__('trans.insu_company_name.text'))
                ->preload()
                ->required()
                ->options([
                    'กรุงเทพประกันภัย' => 'กรุงเทพประกันภัย',
                    'กรุงไทยพานิชประกันภัย' => 'กรุงไทยพานิชประกันภัย',
                    'คุ้มภัยโตเกียวมารีน' => 'คุ้มภัยโตเกียวมารีน',
                    'เคเอสเค ประกันภัย' => 'เคเอสเค ประกันภัย',
                    'เจมาร์ท ประกันภัย' => 'เจมาร์ท ประกันภัย',
                    'ชับบ์สามัคคีประกันภัย' => 'ชับบ์สามัคคีประกันภัย',
                    'ทิพยประกันภัย' => 'ทิพยประกันภัย',
                    'เทเวศประกันภัย' => 'เทเวศประกันภัย',
                    'ไทยไพบูลย์' => 'ไทยไพบูลย์',
                    'ไทยวิวัฒน์' => 'ไทยวิวัฒน์',
                    'ไทยศรี' => 'ไทยศรี',
                    'ไทยเศรษฐฯ' => 'ไทยเศรษฐฯ',
                    'นวกิจประกันภัย' => 'นวกิจประกันภัย',
                    'บริษัทกลางฯ' => 'บริษัทกลางฯ',
                    'แปซิฟิค ครอส' => 'แปซิฟิค ครอส',
                    'เมืองไทยประกันภัย' => 'เมืองไทยประกันภัย',
                    'วิริยะประกันภัย' => 'วิริยะประกันภัย',
                    'สินมั่นคง' => 'สินมั่นคง',
                    'อลิอันซ์ อยุธยา' => 'อลิอันซ์ อยุธยา',
                    'อินทรประกันภัย' => 'อินทรประกันภัย',
                    'เอ็ทน่า' => 'เอ็ทน่า',
                    'เอ็มเอสไอจี' => 'เอ็มเอสไอจี',
                    'แอกซ่าประกันภัย' => 'แอกซ่าประกันภัย',
                    'แอลเอ็มจี ประกันภัย' => 'แอลเอ็มจี ประกันภัย',
                ]),
                TextInput::make('note')
                ->label(__('trans.note.text'))
                ->required(),
                TextInput::make('courier_document')
                ->label(__('trans.courier_document.text'))
                ->required(),
                TextInput::make('recipient_document')
                ->label(__('trans.recipient_document.text'))
                ->required(),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('job_number')->label(__('trans.job_number.text'))->searchable()->sortable(),
                TextColumn::make('approval_number')->label(__('trans.approval_number.text')),
                TextColumn::make('notification_number')->label(__('trans.notification_number.text')),
                TextColumn::make('number_ab')->label(__('trans.number_ab.text')),
                TextColumn::make('vehicle_registration')->label(__('trans.vehicle_registration.text'))->searchable()->sortable(),
                TextColumn::make('amount')->label(__('trans.amount.text')),
                TextColumn::make('vat')->label(__('trans.vat.text')),
                TextColumn::make('aggregate')->label(__('trans.aggregate.text')),
                TextColumn::make('condition_value')->label(__('trans.condition_value.text')),
                TextColumn::make('insu_company_name')->label(__('trans.insu_company_name.text')),
                TextColumn::make('note')->label(__('trans.note.text')),
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
            'index' => Pages\ListApprovalRequests::route('/'),
            'create' => Pages\CreateApprovalRequest::route('/create'),
            'edit' => Pages\EditApprovalRequest::route('/{record}/edit'),
        ];
    }
}
