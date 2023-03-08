<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <meta name="application-name" content="{{ config('app.name') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/car-receive.css')}}">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: rgb(204,204,204);
            font-size: small;
        }
        section[size="A4"] {
            background: white;
            width: 21cm;
            height: 29.7cm;
            display: block;
            margin: 0 auto;
            margin-bottom: 0.5cm;
            box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
        }
        .text-small-f {
            font-size: x-small !important;
        }
        @media print {
            body, section[size="A4"] {
                background: white;
            }
        }
    </style>
</head>


<body class="">
    <section class="bg-white" size="A4">
        <div class="max-w-6xl mx-auto">
            <article class="overflow-hidden">
                <div class="bg-[white]">
                    <div class="p-4">
                        <div class="space-y-6">
                            <div class="container mx-auto flex justify-between">
                                <div class="flex-1">
                                    @if(\Filament\Facades\Filament::auth()->user()->garage == 'SP')
                                        <div class="h-14 w-full">
                                            <img class="object-cover h-full" src="{{ asset('/assets/images/logo_SP.png') }}" />
                                        </div>
                                        <span class="relative"><strong>บริษัท เอส.พี.ภัทร อินเตอร์ทรัค จำกัด</strong></span>
                                        <br>
                                        <span class="relative">ที่อยู่ : 705 หมู่11 ต.คลองด่าน อ.บางบ่อ จ.สมุทรปราการ 10550</span>
                                        <br>
                                        <span class="relative">Tel : 0-2707-6199, 02-330-1525</span>
                                        <br>
                                        <span class="relative">Fax : 02-3301526</span>
                                        <br>
                                        <span class="relative">Email : sppatr.intertruck@gmail.com</span>
                                        <br>
                                        <span class="relative">Line ID : @sp2010</span>
                                    @endif
                                    @if(\Filament\Facades\Filament::auth()->user()->garage == 'SBO')
                                        <div class="h-14 w-full">
                                            <img class="object-cover h-full" src="{{ asset('/assets/images/logo_SBO.png') }}" />
                                        </div>

                                        <span class="relative"><strong>บริษัท สมาร์ท บิวด์ ออโต้ ทรัค จำกัด</strong></span>
                                        <br>
                                        <span class="relative">ที่อยู่ : 337 หมู่ 5 ต.คลองด่าน อ.บางบ่อ จ.สมุทรปราการ 10550</span>
                                        <br>
                                        <span class="relative">Tel : 02-707-6199, 02-330-1525</span>
                                        <br>
                                        <span class="relative">Fax : 02-330-1526</span>
                                        <br>
                                        <span class="relative">Email : sbo.autotruck@gmail.com</span>
                                    @endif
                                </div>
                                <div class="flex-1 pt-10 ml-20">
                                    <div class="flex justify-center">
                                        <h1 class="text-4xl">ใบรับรถ สั่งซ่อม</h1>
                                    </div>
                                    <div class="flex justify-center pb-1">
                                        <p>ต้นฉบับ</p>
                                    </div>
                                    <div class="flex justify-center border-b pb-2">
                                        <p class="">เลขผู้เสียภาษี</p>
                                    </div>
                                    <div class="grid grid-cols-5 gap-x-4 mt-2 px-10">
                                        <div class="col-span-2">
                                            <p class="font-semibold">เลขที่</p>
                                        </div>
                                        <div class="col-span-3">
                                            <p>{{ data_get($data, 'job_number', '-') }}</p>
                                        </div>
                                        <div class="col-span-2">
                                            <p class="font-semibold">วันที่</p>
                                        </div>
                                        <div class="col-span-3">
                                            <p>{{ convertYmdToThaiNumber(data_get($data, 'receive_date')) }}</p>
                                        </div>
                                        <div class="col-span-2">
                                            <p class="font-semibold">ครบกำหนด</p>
                                        </div>
                                        <div class="col-span-3">
                                            <p>{{ convertYmdToThaiNumber(data_get($data, 'pickup_date')) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-9">
                        <div class="w-full">
                            <div class="">
                                <div class=" flex justify-between ">
                                    <p class="font-normal text-slate-700 float-left">
                                        เจ้าของรถ : {{ data_get($data, 'customer', NULL) }}
                                        <br>
                                        ที่อยู่ : {{ data_get($data, 'address', NULL) }} ตำบล{{ data_get($data, 'district', NULL) }}
                                       อำเภอ{{ data_get($data, 'amphoe', NULL) }} จังหวัด{{ data_get($data, 'province', NULL) }} <br> รหัสไปรษณีย์{{ data_get($data, 'zipcode', NULL) }}
                                    </p>
                                    <p></p>
                                    <p class="font-normal text-slate-700 relative ">
                                        ผู้สั่งซ่อม : {{ data_get($data, 'repairman', NULL) }}
                                    </p>
                                </div>
                                <div>
                                </div>
                            </div>
                        <div class="w-full">
                            <div class="flex justify-between">
                                <p class="font-normal text-slate-700 relative top-1">เบอร์ติดต่อเจ้าของรถ : {{ data_get($data, 'customer_tel_number', NULL) }}</p>
                                <p></p>
                                <p class="font-normal tex-slate-700 relative top-1">วันนัดรับรถ : {{ data_get($data, 'pickup_date', NULL) }}</p>
                            </div>
                        </div>
                        <div class="w-full">
                            <div class="flex justify-between">
                                <p class="font-normal text-slate-700 relative top-2">ทะเบียนรถ : {{ data_get($data, 'vehicle_registration', NULL) }}</p>
                                <p class="font-normal text-slate-700 relative top-2">ยี่ห้อรถ : {{ data_get($data, 'brand', NULL) }}</p>
                                <p class="font-normal text-slate-700 relative top-2">รุ่น : {{ data_get($data, 'model', NULL) }}</p>
                                <p class="font-normal text-slate-700 relative top-2">ประเภทรถ : {{ data_get($data, 'car_type', NULL) }}</p>
                            </div>
                        </div>
                        <div class="w-full mt-4">
                            <div class="w-full">
                                <div class="flex space-x-2">
                                    <p class="">รถประกัน</p>
                                    <input type="radio" class="relative" id="name" name="insurance" value="{{ data_get($data, 'options', NULL) }}" disabled checked>
                                    <label for="name" class="relative">เคลมประกันบริษัท : {{ data_get($data, 'insu_company_name', NULL) }}</label>
                                    <div class="flex space-x-2">
                                        <?php  $value = data_get($data, 'insu_company_name', NULL)   ?>
                                        @if($value === NULL)
                                            <input type="radio" class="relative" id="cash" name="insurance" value="{{ data_get($data, 'options', NULL) }}" disabled checked>
                                            <label for="cash" class="relative">เงินสด</label>
                                        @else
                                            <input type="radio" class="relative" id="cash" name="insurance" value="{{ data_get($data, 'options', NULL) }}" disabled>
                                            <label for="cash" class="relative">เงินสด</label>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="w-full mt-1">
                                <div class="flex space-x-2">
                                    <p class="">จอดซ่อม</p>
                                    <input type="radio" id="park" name="park" value="{{ data_get($data, 'park_type', NULL) }}" disabled checked>
                                    <label for="park" class="">จอดซ่อม</label>
                                    <?php  $value = data_get($data, 'park_type', NULL)   ?>
                                    @if($value === NULL)
                                        <input type="radio" id="park-type" name="park" value="{{ data_get($data, 'park_type', NULL) }}" disabled checked>
                                        <label for="park-type" class="">ไม่จอดซ่อม</label>
                                    @else
                                        <input type="radio" id="park-type" name="park" value="{{ data_get($data, 'park_type', NULL) }}" disabled>
                                        <label for="park-type" class="">ไม่จอดซ่อม</label>
                                    @endif
                                    <p></p>
                                    <p class="text-end">เลขไมล์ : {{ data_get($data, 'mile_number', NULL) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-9 content">
                        <div class="flex flex-col mx-0 ">
                            <table class="w-full divide-y divide-slate-500">
                                <thead>
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left font-normal text-slate-700 sm:pl-6 md:pl-0">
                                        บันทึกรายการความเสียหาย
                                    </th>
                                    <th scope="col" class="py-3.5 px-3 text-right  font-normal text-slate-700 sm:table-cell">
                                        สภาพรถและอุปกรณ์
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="document">
                                    <td class="py-9 pl-4 pr-3 text-sm sm:pl-6 md:pl-0 content-1">
                                    {{ data_get($data, 'content', NULL) }}
                                    </td>
                                    <td class="px-3 py-4 text-slate-700 sm:table-cell">
                                        <?php
                                            $spare_tire = data_get($data, 'spare_tire', NULL);
                                            $jack_handle = data_get($data, 'jack_handle', NULL);
                                            $boxset = data_get($data, 'boxset', NULL);
                                            $batteries = data_get($data, 'batteries', NULL);
                                            $cigarette_lighter = data_get($data, 'cigarette_lighter', NULL);
                                            $radio = data_get($data, 'radio', NULL);
                                            $floor_mat = data_get($data, 'floor_mat', NULL);
                                            $spare_removal = data_get($data, 'spare_removal', NULL);
                                            $fire_extinguisher = data_get($data, 'fire_extinguisher', NULL);
                                            $spining_wheel = data_get($data, 'spining_wheel', NULL);
                                            $other = data_get($data, 'other', NULL);
                                        ?>
                                        <div class="grid grid-cols-2">
                                            <div class="flex space-x-2">
                                                @if($spare_tire !== NULL && $spare_tire === 1)
                                                    <input type="checkbox" id="spare_tire" name="spare_tire" class="relativ" value="" disabled checked>
                                                    <label for="spare_tire" class="relative">ยางอะไหล่</label><br>
                                                @else
                                                    <input type="checkbox" id="jack_handle" name="jack_handle" value="" disabled>
                                                    <label for="jack_handle" class="relative">ยางอะไหล่</label><br>
                                                @endif
                                            </div>
                                            <div class="flex space-x-2">
                                                @if($jack_handle !== NULL && $jack_handle === 1)
                                                    <input type="checkbox" id="jack_handle" name="jack_handle" value="" class="relative" disabled checked>
                                                    <label for="jack_handle" class="relative">แม่แรง+ด้าม</label><br>
                                                @else
                                                    <input type="checkbox" id="jack_handle" name="jack_handle" value="" class="relative" disabled>
                                                    <label for="jack_handle" class="relative">แม่แรง+ด้าม</label><br>
                                                @endif
                                            </div>
                                            <div class="flex space-x-2">
                                                @if($boxset !== NULL && $boxset === 1)
                                                    <input type="checkbox" id="boxset" name="boxset" value="" class="relative" disabled checked>
                                                    <label for="boxset" class="relative">ชุดเครื่องมือ คีม, ประแจ, ไขควง</label><br>
                                                @else
                                                    <input type="checkbox" id="boxset" name="boxset" value="" class="relative" disabled>
                                                    <label for="boxset" class="relative">ชุดเครื่องมือ คีม, ประแจ, ไขควง</label><br>
                                                @endif
                                            </div>
                                            <div class="flex space-x-2">
                                                @if($batteries !== NULL && $batteries === 1)
                                                    <input type="checkbox" id="batteries" name="batteries" value="" class="relative" disabled checked>
                                                    <label for="batteries" class="relative">แบตเตอรี่</label><br>
                                                @else
                                                    <input type="checkbox" id="batteries" name="batteries" value="" class="relative" disabled>
                                                    <label for="batteries" class="relative">แบตเตอรี่</label><br>
                                                @endif
                                            </div>
                                            <div class="flex space-x-2">
                                                @if($cigarette_lighter !== NULL && $cigarette_lighter === 1)
                                                    <input type="checkbox" id="cigarette_lighter" name="cigarette_lighter" value="" class="relative" disabled checked>
                                                    <label for="cigarette_lighter" class="relative">ที่จุดบุหรี่</label><br>
                                                @else
                                                    <input type="checkbox" id="cigarette_lighter" name="cigarette_lighter" value="" class="relative" disabled>
                                                    <label for="cigarette_lighter" class="relative">ที่จุดบุหรี่</label><br>
                                                @endif
                                            </div>
                                            <div class="flex space-x-2">
                                                @if($radio !== NULL && $radio === 1)
                                                    <input type="checkbox" id="radio" name="radio" value="" class="relative" disabled checked>
                                                    <label for="radio" class="relative">วิทยุ/CD</label><br>
                                                @else
                                                    <input type="checkbox" id="radio" name="radio" value="" class="relative" disabled>
                                                    <label for="radio" class="relative">วิทยุ/CD</label><br>
                                                @endif
                                            </div>
                                            <div class="flex space-x-2">
                                                @if($floor_mat !== NULL && $floor_mat === 1)
                                                    <input type="checkbox" id="floor_mat" name="floor_mat" value="" class="relative" disabled checked>
                                                    <label for="floor_mat" class="relative">ผ้ายางปูพื้น</label><br>
                                                @else
                                                    <input type="checkbox" id="floor_mat" name="floor_mat" value="" class="relative" disabled>
                                                    <label for="floor_mat" class="relative">ผ้ายางปูพื้น</label><br>
                                                @endif
                                            </div>
                                            <div class="flex space-x-2">
                                                @if($spare_removal !== NULL && $spare_removal === 1)
                                                    <input type="checkbox" id="spare_removal" name="floor_mat" value="" class="relative" disabled checked>
                                                    <label for="spare_removal" class="relative">ชุดถอดยางอะไหล่</label><br>
                                                @else
                                                    <input type="checkbox" id="spare_removal" name="spare_removal" value="" class="relative" disabled>
                                                    <label for="spare_removal" class="relative">ชุดถอดยางอะไหล่</label><br>
                                                @endif
                                            </div>
                                            <div class="flex space-x-2">
                                                @if($fire_extinguisher !== NULL && $fire_extinguisher === 1)
                                                    <input type="checkbox" id="fire_extinguisher" name="fire_extinguisher" value="" class="relative" disabled checked>
                                                    <label for="fire_extinguisher" class="relative">ถังดับเพลิง</label><br>
                                                @else
                                                    <input type="checkbox" id="fire_extinguisher" name="fire_extinguisher" value="" class="relative" disabled>
                                                    <label for="fire_extinguisher" class="relative">ถังดับเพลิง</label><br>
                                                @endif
                                            </div>
                                            <div class="flex space-x-2">
                                                @if($spining_wheel !== NULL && $spining_wheel === 1)
                                                    <input type="checkbox" id="spining_wheel" name="spining_wheel" value="" class="relative" disabled checked>
                                                    <label for="spining_wheel" class="relative">ไม้หมุนล้อ</label><br>
                                                @else
                                                    <input type="checkbox" id="spining_wheel" name="spining_wheel" value="" class="relative" disabled>
                                                    <label for="spining_wheel" class="relative">ไม้หมุนล้อ</label><br>
                                                @endif
                                            </div>
                                            <div class="flex space-x-2">
                                                @if($other !== NULL && $other === 1)
                                                    <input type="checkbox" id="other" name="other" value="" class="relative" disabled checked>
                                                    <label for="other" class="relative">อื่น ๆ</label><br>
                                                @else
                                                    <input type="checkbox" id="other" name="other" value="" class="relative" disabled>
                                                    <label for="other" class="relative">อื่น ๆ</label><br>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <thead>
                                    <tr class="document">
                                        <th scope="col" class="py-1.5 pl-4 pr-3 text-left font-normal text-slate-700 sm:pl-6 md:pl-0">
                                            เอกสารที่รับจากลูกค้าวันเข้าซ่อม
                                        </th>
                                        <th scope="col" class="py-1.5 px-3 text-right  font-normal text-slate-700 sm:table-cell">
                                            เอกสารที่ลูกค้านำมาวันรับรถ
                                        </th>
                                    </tr>
                                </thead>

                                <tr class="border-b border-slate-700">
                                    <td class="py-4 pl-4 pr-3  sm:pl-6 md:pl-0" colspan="2">
                                        <?php
                                            $real_claim_document = data_get($data, 'real_claim_document', NULL); //ใบเคลมฉบับจริง
                                            $copy_policy_document = data_get($data, 'copy_policy_document', NULL); //
                                            $copy_claim_document = data_get($data, 'copy_claim_document', NULL);
                                            $power_of_attorney_document = data_get($data, 'power_of_attorney_document', NULL);
                                            $copy_driver_license_document = data_get($data, 'copy_driver_license_document', NULL);
                                            $copy_of_director_id_card_document = data_get($data, 'copy_of_director_id_card_document', NULL);
                                            $copy_vehicle_regis_document = data_get($data, 'copy_vehicle_regis_document', NULL);
                                            $copy_of_person_document = data_get($data, 'copy_of_person_document', NULL);
                                            $account_book_document = data_get($data, 'account_book_document', NULL);
                                            $atm_card_document = data_get($data, 'atm_card_document', NULL);
                                            $other_document = data_get($data, 'other_document', NULL);
                                            $cassie_number_document = data_get($data, 'cassie_number_document', NULL);
                                        ?>

                                        <div class="grid grid-cols-3">
                                            <div class="flex space-x-2">
                                                @if($real_claim_document !== NULL && $real_claim_document === 1)
                                                <input type="checkbox" id="real_claim_document" name="real_claim_document" value="" class="relative" disabled checked>
                                                <label for="real_claim_document" class="relative">ใบเคลมฉบับจริง</label><br>
                                                @else
                                                <input type="checkbox" id="real_claim_document" name="real_claim_document" value="" class="relative" disabled>
                                                <label for="real_claim_document" class="relative">ใบเคลมฉบับจริง</label><br>
                                                @endif
                                            </div>
                                            <div class="flex space-x-2">
                                                @if($copy_policy_document !== NULL && $copy_policy_document === 1)
                                                <input type="checkbox" id="copy_policy_document" name="copy_policy_document" value="" class="relative" disabled checked>
                                                <label for="copy_policy_document" class="relative">สำเนากรมธรรม์</label><br>
                                                @else
                                                <input type="checkbox" id="copy_policy_document" name="copy_policy_document" value="" class="relative" disabled>
                                                <label for="copy_policy_document" class="relative">สำเนากรมธรรม์</label><br>
                                                @endif
                                            </div>
                                            <br>
                                            <div class="">
                                                @if($power_of_attorney_document !== NULL && $power_of_attorney_document === 1)
                                                <input type="checkbox" id="power_of_attorney_document" name="power_of_attorney_document" value="" class="relative" disabled checked>
                                                <label for="power_of_attorney_document" class="relative">หนังสือมอบอำนาจ</label><br>
                                                @else
                                                <input type="checkbox" id="power_of_attorney_document" name="power_of_attorney_document" value="" class="relative" disabled>
                                                <label for="power_of_attorney_document" class="relative">หนังสือมอบอำนาจ</label><br>
                                                @endif
                                            </div>
                                            <div class="flex space-x-2">
                                                @if($copy_driver_license_document !== NULL && $copy_driver_license_document === 1)
                                                <input type="checkbox" id="copy_driver_license_document" name="copy_driver_license_document" value="" class="relative" disabled checked>
                                                <label for="copy_driver_license_document" class="relative">สำเนาใบเคลม</label><br>
                                                @else
                                                <input type="checkbox" id="copy_driver_license_document" name="copy_driver_license_document" value="" class="relative" disabled>
                                                <label for="copy_driver_license_document" class="relative">สำเนาใบเคลม</label><br>
                                                @endif
                                            </div>
                                            <br>
                                            <div class="flex space-x-2">
                                                @if($copy_of_director_id_card_document !== NULL && $copy_of_director_id_card_document === 1)
                                                <input type="checkbox" id="copy_of_director_id_card_document" name="copy_of_director_id_card_document" value="" class="relative" disabled checked>
                                                <label for="copy_of_director_id_card_document" class="relative">สำเนาบัตรประชาชนกรรมการ</label><br>
                                                @else
                                                <input type="checkbox" id="copy_of_director_id_card_document" name="copy_of_director_id_card_document" value="" class="relative" disabled>
                                                <label for="copy_of_director_id_card_document" class="relative">สำเนาบัตรประชาชนกรรมการ</label><br>
                                                @endif
                                            </div>
                                            <div class="flex space-x-2">
                                                @if($copy_vehicle_regis_document !== NULL && $copy_vehicle_regis_document === 1)
                                                <input type="checkbox" id="copy_vehicle_regis_document" name="copy_vehicle_regis_document" value="" class="relative" disabled checked>
                                                <label for="copy_vehicle_regis_document" class="relative">สำเนาทะเบียนรถ</label><br>
                                                @else
                                                <input type="checkbox" id="copy_vehicle_regis_document" name="copy_vehicle_regis_document" value="" class="relative" disabled>
                                                <label for="copy_vehicle_regis_document" class="relative">สำเนาทะเบียนรถ</label><br>
                                                @endif
                                            </div><br>
                                            <div class="">
                                                @if($copy_of_person_document !== NULL && $copy_of_person_document === 1)
                                                <input type="checkbox" id="copy_of_person_document" name="copy_of_person_document" value="" class="relative" disabled checked>
                                                <label for="copy_of_person_document" class="relative">สำเนาหนังสือรับรองนิติบุคคล(ยังไม่หมดอายุ)</label><br>
                                                @else
                                                <input type="checkbox" id="copy_of_person_document" name="copy_of_person_document" value="" class="relative" disabled>
                                                <label for="copy_of_person_document" class="relative">สำเนาหนังสือรับรองนิติบุคคล(ยังไม่หมดอายุ)</label><br>
                                                @endif
                                            </div>

                                            <div class="flex space-x-2">
                                                @if($account_book_document !== NULL && $account_book_document === 1)
                                                <input type="checkbox" id="account_book_document" name="copy_of_person_document" value="" class="relative" disabled checked>
                                                <label for="account_book_document" class="relative">หน้าสมุดบัญชีธนาคาร</label><br>
                                                @else
                                                <input type="checkbox" id="account_book_document" name="account_book_document" value="" class="relative" disabled>
                                                <label for="account_book_document" class="relative">หน้าสมุดบัญชีธนาคาร</label><br>
                                                @endif
                                            </div><br>
                                            <div class="">
                                                @if($atm_card_document !== NULL && $atm_card_document === 1)
                                                <input type="checkbox" id="atm_card_document" name="atm_card_document" value="" class="relative" disabled checked>
                                                <label for="atm_card_document" class="relative">บัตรATM</label><br>
                                                @else
                                                <input type="checkbox" id="atm_card_document" name="atm_card_document" value="" class="relative" disabled>
                                                <label for="atm_card_document" class="relative">บัตรATM</label><br>
                                                @endif
                                            </div>
                                            <div class="flex space-x-2">
                                                @if($cassie_number_document !== NULL && $cassie_number_document === 1)
                                                <input type="checkbox" id="cassie_number_document" name="cassie_number_document" value="" class="relative" disabled checked>
                                                <label for="cassie_number_document" class="relative">เลขคัชชี</label><br>
                                                @else
                                                <input type="checkbox" id="cassie_number_document" name="cassie_number_document" value="" class="relative" disabled>
                                                <label for="cassie_number_document" class="relative">เลขคัชชี</label><br>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-4 text-right text-slate-700 sm:table-cell">

                                    </td>
                                </tr>

                                <!-- Here you can write more products/tasks that you want to charge for-->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </article>
        </div>
        <div class="flex justify-center p-4">
            <button onclick="window.print()" class="bg-green-400 py-2 px-4 text-gray-50 rounded">Print</button>
        </div>
    </section>
    <script>

    </script>
</body>
</html>
