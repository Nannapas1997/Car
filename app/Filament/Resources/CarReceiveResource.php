<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\CarReceive;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Radio;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MultiSelect;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CarReceiveResource\Pages;
use App\Filament\Resources\CarReceiveResource\RelationManagers;
use Filament\Forms\Components\Select;
use Filament\Http\Livewire\GlobalSearch;
use Livewire\TemporaryUploadedFile;

class CarReceiveResource extends Resource
{
    protected static ?string $model = CarReceive::class;
    protected static ?string $navigationGroup = 'My Work';
    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Radio::make('เลือกอู่')->label("กรุณาเลือกอู่ที่ต้องการ")->options(['SP' => 'SP auto','SBO' => 'SBO'])->columns(3),
            
            Select::make('เลขที่งาน')->label("เลขที่งาน")->preload()->options(CarReceive::query()->pluck('เลขที่งาน(กรณีลูกค้ารายใหม่)')),
            TextInput::make('เลขที่งาน(กรณีลูกค้ารายใหม่)')->label("เลขที่งาน(กรณีลูกค้ารายใหม่)"),
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
            Radio::make('ระบุตัวเลือก')->label("ระบุตัวเลือก")->options(['รถประกัน' => 'รถประกัน','รถคู่กรณี' => 'รถคู่กรณี','ฝ่ายถูก'=>'ฝ่ายถูก','ฝ่ายผิด'=>'ฝ่ายผิด','คดี'=>'คดี','เคลมประกันบริษัท'=>'เคลมประกันบริษัท','เงินสด'=>'เงินสด'])->columns(8)->required(),
            TextInput::make('ชื่อบริษัทประกันภัย')->label('ชื่อบริษัทประกันภัย')->required(),
            TextInput::make('เลขกรมธรรม์')->label('เลขกรมธรรม์')->required(),
            TextInput::make('เลขที่รับแจ้ง')->label('เลขที่รับแจ้ง')->required(),
            TextInput::make('เลขที่เคลม')->label('เลขที่เคลม')->required(),
            Radio::make('ประเภทการจอด')->label("ประเภทการจอด")->options(['จอดซ่อม' => 'จอดซ่อม','ไม่จอดซ่อม' => 'ไม่จอดซ่อม'])->columns(3),
            DatePicker::make('วันที่รถเข้ามาจอด')->label('วันที่รถเข้ามาจอด')->required(),
            FileUpload::make('ใบเคลมฉบับจริง')->label('ใบเคลมฉบับจริง'),
            FileUpload::make('สำเนาใบเคลม')->label('สำเนาใบเคลม'),
            FileUpload::make('สำเนาใบขับขี่')->label('สำเนาใบขับขี่'),
            FileUpload::make('สำเนาทะเบียนรถ')->label('สำเนาทะเบียนรถ'),
            FileUpload::make('สำเนากรมธรรม์')->label('สำเนากรมธรรม์'),
            FileUpload::make('หนังสือมอบอำนาจ')->label('หนังสือมอบอำนาจ'),
            FileUpload::make('สำเนาบัตรประชาชนกรรมการ')->label('สำเนาบัตรประชาชนกรรมการ'),
            FileUpload::make('สำเนาหนังสือรับรองนิติบุคคล(ยังไม่หมดอายุ)')->label('สำเนาหนังสือรับรองนิติบุคคล(ยังไม่หมดอายุ)'),
            FileUpload::make('หน้าสมุดบัญชีธนาคาร')->label('หน้าสมุดบัญชีธนาคาร'),
            FileUpload::make('บัตร ATM')->label('บัตร ATM'),
            FileUpload::make('ด้านหน้ารถ')->label('ด้านหน้ารถ'),
            FileUpload::make('ด้านซ้ายรถ')->label('ด้านซ้ายรถ'),
            FileUpload::make('ด้านขวารถ')->label('ด้านขวารถ'),
            FileUpload::make('ด้านหลังรถ')->label('ด้านหลังรถ'),
            FileUpload::make('ภายในเก๋งด้านซ้าย')->label('ภายในเก๋งด้านซ้าย'),
            FileUpload::make('ภายในเก๋งด้านขวา')->label('ภายในเก๋งด้านขวา'),
            FileUpload::make('ในตู้บรรทุก')->label('ในตู้บรรทุก'),
            FileUpload::make('ภาพอื่นๆ')->label('ภาพอื่นๆ'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('เลือกอู่'),
                TextColumn::make('เลขที่งาน'),
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
                TextColumn::make('ประเภทของการซ่อมรถ'),
                TextColumn::make('ชื่อบริษัทประกันภัย'),
                TextColumn::make('เลขกรมธรรม์'),
                TextColumn::make('เลขที่รับแจ้ง'),
                TextColumn::make('เลขที่เคลม'),
                TextColumn::make('ประเภทการจอด'),
                TextColumn::make('วันที่รถเข้ามาจอด'),
                TextColumn::make('ใบเคลมฉบับจริง'),
                TextColumn::make('สำเนาใบเคลม'),
                TextColumn::make('สำเนาใบขับขี่'),
                TextColumn::make('สำเนาทะเบียนรถ'),
                TextColumn::make('สำเนากรมธรรม์'),
                TextColumn::make('หนังสือมอบอำนาจ'),
                TextColumn::make('สำเนาบัตรประชาชนกรรมการ'),
                TextColumn::make('สำเนาหนังสือรับรองนิติบุคคล(ยังไม่หมดอายุ)'),
                TextColumn::make('หน้าสมุดบัญชีธนาคาร'),
                TextColumn::make('บัตร ATM'),
                TextColumn::make('ด้านหน้ารถ'),
                TextColumn::make('ด้านซ้ายรถ'),
                TextColumn::make('ด้านขวารถ'),
                TextColumn::make('ด้านหลังรถ'),
                TextColumn::make('ภายในเก๋งด้านซ้าย'),
                TextColumn::make('ภายในเก๋งด้านขวา'),
                TextColumn::make('ในตู้บรรทุก'),
                TextColumn::make('ภาพอื่น ๆ'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                DeleteAction::make(),
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
            'index' => Pages\ListCarReceives::route('/'),
            'create' => Pages\CreateCarReceive::route('/create'),
            'edit' => Pages\EditCarReceive::route('/{record}/edit'),
        ];
    }
}
