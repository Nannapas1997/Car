<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <meta name="application-name" content="{{ config('app.name') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>{{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: rgb(204,204,204);
            font-size: small;
            font-family: 'Kanit' !important;
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
        input[type="checkbox"] {
            width: 18px !important;
            height: 18px !important;
        }
        @media print {
            body, section[size="A4"] {
                background: white;
            }
        }
    </style>
</head>

<body class="">
<section size="A4" class="bg-white">
    <div class="x-auto">
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

                                <br>
                                <br>

                            </div>
                            <div class="flex-1 pt-10 ml-20">
                                <div class="flex justify-center">
                                    <h1 class="text-4xl">ใบปล่อยรถ</h1>
                                </div>
                                <div class="flex justify-center pb-1">
                                    <p>ต้นฉบับ</p>
                                </div>
                                <div class="grid grid-cols-4 gap-x-4 mt-2 px-10">
                                    <div class="col-span-4">
                                        <p class="font-semibold">เลขที่ <span class="font-normal">{{ data_get($data, 'job_number', '-') }}</span></p>
                                    </div>
                                    <div class="col-span-4">
                                        <p class="font-semibold">เลขที่ใบปล่อยรถ  <span class="font-normal">{{ data_get($data, 'oc_number', '-') }}</span></p>
                                    </div>
                                    <div class="col-span-4">
                                        <p class="font-semibold">วันที่ <span class="font-normal">{{ convertYmdToThaiNumber(\Carbon\Carbon::now()->format('Y-m-d')) }}</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-9">
                    <div class="flex w-full">
                        <div class="w-full grid grid-cols-6 gap-3">
                            <div class="text-lg text-slate-500 col-span-3 space-y-2">
                                <p class="text-lg font-normal text-slate-700">
                                    ชื่อ (ข้าพเจ้า) : {{ data_get($data, 'staff_name', '-') }}
                                </p>
                                <p class="text-lg font-normal text-slate-700">
                                    ตำแหน่งที่เกี่ยงข้องกับ บจ./หจก. : {{ data_get($data, 'staff_position', '-') }}
                                </p>
                                <p class="text-lg font-normal text-slate-700">
                                    จากบริษัท (SP / SBO) : {{ data_get($data, 'choose_garage', '-') }}
                                </p>
                                <p class="text-lg font-normal text-slate-700">
                                    ยี่ห้อรถที่มารับ : {{ data_get($data, 'brand', '-') }}
                                </p>
                            </div>
                            <div class="text-normal text-slate-500 col-span-3 space-y-2">
                                <p class="text-lg font-normal text-slate-700">
                                    เลขทะเบียน : {{ data_get($data, 'vehicle_registration', '-') }}
                                </p>
                                <p class="text-lg font-normal text-slate-700">
                                    เลขกรมธรรม์ : {{ data_get($data, 'policy_number', '-') }}
                                </p>

                                <p class="text-lg font-normal text-slate-700">
                                    เลขเคลม / เลขรับแจ้งที่ : {{ data_get($data, 'claim_number', '-') }}
                                </p>

                            </div>
                            <div class="text-left col-span-6">
                                <p class="text-lg font-normal text-slate-700">
                                    ชื่อบริษัทประกันภัยของรถ : {{ data_get($data, 'insu_company_name', '-') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                // dd($data);
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
                <div class="grid grid-cols-3 ml-10 mt-3">

                    <div class="flex space-x-2 ">
                        @if($real_claim_document !== NULL && $real_claim_document == 1)
                        <input type="checkbox" id="real_claim_document" name="real_claim_document" value="" class="relative" disabled checked>
                        <label for="real_claim_document" class="relative">ใบเคลมฉบับจริง</label><br>
                        @else
                        <input type="checkbox" id="real_claim_document" name="real_claim_document" value="" class="relative" disabled>
                        <label for="real_claim_document" class="relative">ใบเคลมฉบับจริง</label><br>
                        @endif
                    </div>
                    <div class="flex space-x-2">
                        @if($copy_policy_document !== NULL && $copy_policy_document == 1)
                        <input type="checkbox" id="copy_policy_document" name="copy_policy_document" value="" class="relative" disabled checked>
                        <label for="copy_policy_document" class="relative">สำเนากรมธรรม์</label><br>
                        @else
                        <input type="checkbox" id="copy_policy_document" name="copy_policy_document" value="" class="relative" disabled>
                        <label for="copy_policy_document" class="relative">สำเนากรมธรรม์</label><br>
                        @endif
                    </div>
                    <br>
                    <div class="flex space-x-2">
                        @if($power_of_attorney_document !== NULL && $power_of_attorney_document == 1)
                        <input type="checkbox" id="power_of_attorney_document" name="power_of_attorney_document" value="" class="relative" disabled checked>
                        <label for="power_of_attorney_document" class="relative">หนังสือมอบอำนาจ</label><br>
                        @else
                        <input type="checkbox" id="power_of_attorney_document" name="power_of_attorney_document" value="" class="relative" disabled>
                        <label for="power_of_attorney_document" class="relative">หนังสือมอบอำนาจ</label><br>
                        @endif
                    </div>
                    <div class="flex space-x-2">
                        @if($copy_driver_license_document !== NULL && $copy_driver_license_document == 1)
                        <input type="checkbox" id="copy_driver_license_document" name="copy_driver_license_document" value="" class="relative" disabled checked>
                        <label for="copy_driver_license_document" class="relative">สำเนาใบเคลม</label><br>
                        @else
                        <input type="checkbox" id="copy_driver_license_document" name="copy_driver_license_document" value="" class="relative" disabled>
                        <label for="copy_driver_license_document" class="relative">สำเนาใบเคลม</label><br>
                        @endif
                    </div>
                    <br>
                    <div class="flex space-x-2">
                        @if($copy_of_director_id_card_document !== NULL && $copy_of_director_id_card_document == 1)
                        <input type="checkbox" id="copy_of_director_id_card_document" name="copy_of_director_id_card_document" value="" class="relative" disabled checked>
                        <label for="copy_of_director_id_card_document" class="relative">สำเนาบัตรประชาชนกรรมการ</label><br>
                        @else
                        <input type="checkbox" id="copy_of_director_id_card_document" name="copy_of_director_id_card_document" value="" class="relative" disabled>
                        <label for="copy_of_director_id_card_document" class="relative">สำเนาบัตรประชาชนกรรมการ</label><br>
                        @endif
                    </div>
                    <div class="flex space-x-2">
                        @if($copy_vehicle_regis_document !== NULL && $copy_vehicle_regis_document == 1)
                        <input type="checkbox" id="copy_vehicle_regis_document" name="copy_vehicle_regis_document" value="" class="relative" disabled checked>
                        <label for="copy_vehicle_regis_document" class="relative">สำเนาทะเบียนรถ</label><br>
                        @else
                        <input type="checkbox" id="copy_vehicle_regis_document" name="copy_vehicle_regis_document" value="" class="relative" disabled>
                        <label for="copy_vehicle_regis_document" class="relative">สำเนาทะเบียนรถ</label><br>
                        @endif
                    </div><br>
                    <div class="flex space-x-2">
                        @if($copy_of_person_document !== NULL && $copy_of_person_document == 1)
                        <input type="checkbox" id="copy_of_person_document" name="copy_of_person_document" value="" class="relative" disabled checked>
                        <label for="copy_of_person_document" class="relative">สำเนาหนังสือรับรองนิติบุคคล(ยังไม่หมดอายุ)</label><br>
                        @else
                        <input type="checkbox" id="copy_of_person_document" name="copy_of_person_document" value="" class="relative" disabled>
                        <label for="copy_of_person_document" class="relative">สำเนาหนังสือรับรองนิติบุคคล(ยังไม่หมดอายุ)</label><br>
                        @endif
                    </div>

                    <div class="flex space-x-2">
                        @if($account_book_document !== NULL && $account_book_document == 1)
                        <input type="checkbox" id="account_book_document" name="copy_of_person_document" value="" class="relative" disabled checked>
                        <label for="account_book_document" class="relative">หน้าสมุดบัญชีธนาคาร</label><br>
                        @else
                        <input type="checkbox" id="account_book_document" name="account_book_document" value="" class="relative" disabled>
                        <label for="account_book_document" class="relative">หน้าสมุดบัญชีธนาคาร</label><br>
                        @endif
                    </div><br>
                    <div class="">
                        @if($atm_card_document !== NULL && $atm_card_document == 1)
                        <input type="checkbox" id="atm_card_document" name="atm_card_document" value="" class="relative" disabled checked>
                        <label for="atm_card_document" class="relative">บัตรATM</label><br>
                        @else
                        <input type="checkbox" id="atm_card_document" name="atm_card_document" value="" class="relative" disabled>
                        <label for="atm_card_document" class="relative">บัตรATM</label><br>
                        @endif
                    </div>
                    <div class="flex space-x-2">
                        @if($cassie_number_document !== NULL && $cassie_number_document == 1)
                        <input type="checkbox" id="cassie_number_document" name="cassie_number_document" value="" class="relative" disabled checked>
                        <label for="cassie_number_document" class="relative">เลขคัชชี</label><br>
                        @else
                        <input type="checkbox" id="cassie_number_document" name="cassie_number_document" value="" class="relative" disabled>
                        <label for="cassie_number_document" class="relative">เลขคัชชี</label><br>
                        @endif
                    </div>
                    <div class="flex space-x-2">
                        @if($copy_driver_license_document !== NULL && $copy_driver_license_document == 1)
                        <input type="checkbox" id="copy_driver_license_document" name="copy_driver_license_document" value="" class="relative" disabled checked>
                        <label for="copy_driver_license_document" class="relative">สำเนาใบขับขี่</label><br>
                        @else
                        <input type="checkbox" id="copy_driver_license_document" name="copy_driver_license_document" value="" class="relative" disabled>
                        <label for="copy_driver_license_document" class="relative">สำเนาใบขับขี่</label><br>
                        @endif
                    </div>
                </div>
                <div class="p-9">
                    <div class="border-b border-slate-200">
                        <div class="text-lg font-light text-slate-700">
                            <p class="text-center">
                                ข้าพเจ้าได้ตรวจสอบรถยนต์คันดังกล่าวอย่างละเอียดแล้ว พบว่ารถยนต์ดำเนินการจัดซ่อมอยู่ในสภาพเรียบร้อย ใช้งานได้ปกติ
                            </p>
                            <p class="text-center">
                                จึงขอลงลายมือชื่อรับรถไว้เป็นหลักฐาน
                            </p>
                            <div class="flex justify-between mt-9 mb-9">
                                <div class="flex-1 w-full"></div>
                                <div class="flex-1 w-full">
                                    <p class="text-center">
                                        ลงชื่อ (ผู้รับรถยนต์)
                                    </p>
                                    <p class="mt-16 border-b border-slate-200">&nbsp;</p>
                                </div>
                                <div class="flex-1 w-full"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </div>
    <div class="flex justify-center p-4">
        <button onclick="window.print()" class="bg-green-400 py-2 px-4 text-gray-50 rounded">Print</button>
    </div>
</section>
</body>
</html>
