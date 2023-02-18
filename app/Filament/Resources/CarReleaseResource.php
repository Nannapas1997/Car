<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarReleaseResource\Pages;
use App\Filament\Resources\CarReleaseResource\RelationManagers;
use App\Models\CarRelease;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CarReleaseResource extends Resource
{
    protected static ?string $model = CarRelease::class;
    protected static ?string $navigationGroup = 'Account';
    protected static ?string $navigationIcon = 'heroicon-o-arrows-expand';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('job_number')->label('Job No'),
                TextInput::make('staff_name')->label('ชื่อ (ข้าพเจ้า)'),
                TextInput::make('staff_position')->label('ตำแหน่งที่เกี่ยวข้องกับ บจ./หจก.'),
                TextInput::make('car_brand')->label('ยี่ห้อรถที่มารับ'),
                TextInput::make('vehicle_registration')->label('เลขทะเบียนรถ'),
                TextInput::make('garage')->label('จากบริษัท (SP / SBO)'),
                TextInput::make('insurance_name')->label('ชื่อบริษัทประกันภัยของรถ'),
                TextInput::make('policy_number')->label('เลขกรมธรรม์'),
                TextInput::make('claim_number')->label('เลขเคลม / เลขรับแจ้งที่'),
                TextInput::make('save_repair_cost_id')
                    ->label('save_repair_cost_id')
                    ->numeric()
                    ->default(1),
                TextInput::make('code_c0_c7')
                    ->label('code_c0_c7')
                    ->default('-'),
                TextInput::make('price')
                    ->label('price')
                    ->default('-'),
                TextInput::make('spare_code')
                    ->label('spare_code')
                    ->default('-'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('job_number')->label(__('trans.job_number.text')),
                TextColumn::make('staff_name')->label(__('trans.staff_name.text')),
                TextColumn::make('staff_position')->label(__('trans.staff_position.text')),
                TextColumn::make('vehicle_registration')->label(__('trans.vehicle_registration.text')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
//                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListCarReleases::route('/'),
            'create' => Pages\CreateCarRelease::route('/create'),
            'edit' => Pages\EditCarRelease::route('/{record}/edit'),
        ];
    }
}
