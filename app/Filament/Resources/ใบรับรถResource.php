<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\ใบรับรถ;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Radio;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MultiSelect;
use App\Filament\Resources\ใบรับรถResource\Pages;
use Filament\Forms\Components\DatePicker;
use Suleymanozev\FilamentRadioButtonField\Forms\Components\RadioButton;

class ใบรับรถResource extends Resource
{
    protected static ?string $model = ใบรับรถ::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationGroup = 'My Work';
    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            // Radio::make('เลือกอู่')->label("กรุณาเลือกอู่ที่ต้องการ")->options(['1' => 'SP auto','2' => 'SBO'])->columns(3),
            // MultiSelect::make('เลขที่งาน')->label("เลขที่งาน")->preload(),
            TextInput::make('เลขที่งาน(กรณีลูกค้ารายใหม่)')->label("เลขที่งาน(กรณีลูกค้ารายใหม่)")->default('sp5678')->required(),
            DatePicker::make('date')->label('วันที่รับเรื่อง')->required(),
            TimePicker::make('เวลา')->label('เวลา'),
            TextInput::make('เจ้าของรถ')->label('เจ้าของรถ')->required(),
            TextInput::make('ผู้สั่งซ่อม')->label('ผู้สั่งซ่อม')->required(),
            TextInput::make('เบอร์ติดต่อ')->label('เบอร์ติดต่อ')->required(),
            DatePicker::make('date')->label('วันนัดรับรถ'),
            TextInput::make('ทะเบียนรถ')->label('ทะเบียนรถ')->required(),
            TextInput::make('ยี่ห้อรถ')->label('ยี่ห้อรถ')->required(),
            TextInput::make('รุ่น')->label('รุ่น')->required(),
            TextInput::make('ประเภทรถ')->label('ประเภทรถ')->required(),
            TextInput::make('รหัสซ่อม')->label('รหัสซ่อม')->required(),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // TextColumn::make('เลือกอู่'),
                // TextColumn::make('เลขที่งาน'),
                TextColumn::make('เลขที่งานกรณีลูกค้ารายใหม่'),
                TextColumn::make('วันที่รับเรื่อง'),
                TextColumn::make('เวลา'),
                TextColumn::make('เจ้าของรถ'),
                TextColumn::make('ผู้่สั่งซ่อม'),
                TextColumn::make('เบอร์ติดต่อ'),
                TextColumn::make('วันนัดรับรถ'),
                TextColumn::make('ทะเบียนรถ'),
                TextColumn::make('ยี่ห้อรถ'),
                TextColumn::make('รุ่น'),
                TextColumn::make('ประเภทรถ'),
                TextColumn::make('รหัสซ่อม'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\Manageใบรับรถs::route('/'),
        ];
    }
}
