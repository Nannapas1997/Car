<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_receives', function (Blueprint $table) {
            $table->id();
            $table->string('เลือกอู่')->required();
            $table->string('เลขที่งาน')->default('SP23-1234')->unique()->searchable()->required;
            $table->string('เลขที่งาน(กรณีลูกค้ารายใหม่')->unique()->default('SP23-1234')->required;
            $table->date('วันที่รับเรื่อง')->required()->default('Jan 18, 2023');
            $table->time('เวลา')->required()->default('09:00:00');
            $table->string('เจ้าของรถ')->default('นายสมชาย ภักดี')->required()->unique();
            $table->string('ผู้สั่งซ่อม')->default('นายศุภโชค แสนแก้ว')->required()->unique();
            $table->string('เบอร์ติดต่อ')->default('0823508565')->required();
            $table->date('วันนัดรับรถ')->required()->default('Jan 18, 2023');;
            $table->string('ทะเบียนรถ')->default('กจ6409')->required()->unique();
            $table->string('ยี่ห้อรถ')->default('Honda')->required();
            $table->string('รุ่น')->required()->default('Civic');
            $table->string('ประเภทรถ')->required()->default('รถเก๋ง');
            $table->string('เลขไมล์')->required()->default('56785');
            $table->string('รหัสซ่อม')->required()->default('A');
            $table->string('ประเภทของการซ่อมรถ')->required()->default('คดี');
            $table->string('ชื่อบริษัทประกันภัย')->required()->default('วิริยะประกันภัย');
            $table->string('เลขกรมธรรม์')->require()->default('12345678');
            $table->string('เลขที่รับแจ้ง')->required()->default('12345678');;
            $table->string('เลขที่เคลม')->required()->default('12345678');;
            $table->string('ประเภทการจอด')->required()->default('จอดซ่อม');
            $table->date('วันที่รถเข้ามาจอด')->required()->default('Jan 18, 2023');
            $table->string('ใบเคลมฉบับจริง')->required()->nullable();
            $table->string('สำเนาใบเคลม')->required()->nullable();
            $table->string('สำเนาใบขับขี่')->required()->nullable();
            $table->string('สำเนาทะเบียนรถ')->required()->nullable();
            $table->string('สำเนากรมธรรม์')->required()->nullable();
            $table->string('หนังสือมอบอำนาจ')->required()->nullable();
            $table->string('สำเนาบัตรประชาชนกรรมการ')->required()->nullable();
            $table->string('สำเนาหนังสือรับรองนิติบุคคล(ยังไม่หมดอายุ)')->required()->nullable();
            $table->string('หน้าสมุดบัญชีธนาคาร')->required()->nullable();
            $table->string('บัตร ATM')->required()->nullable();
            $table->string('ด้านหน้ารถ')->required()->nullable();
            $table->string('ด้านซ้ายรถ')->required()->nullable();
            $table->string('ด้านขวารถ')->required()->nullable();
            $table->string('ด้านหลังรถ')->required()->nullable();
            $table->string('ภายในเก๋งด้านซ้าย')->required()->nullable();
            $table->string('ภายในเก๋งด้านขวา')->required()->nullable();
            $table->string('ในตู้บรรทุก')->required()->nullable();
            $table->string('ภาพอื่น ๆ')->required()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('car_receives');
    }
};
