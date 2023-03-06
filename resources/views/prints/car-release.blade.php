<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <meta name="application-name" content="{{ config('app.name') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="">
<section class="bg-white">
    <div class="max-w-5xl mx-auto">
        <article class="overflow-hidden">
            <div class="bg-[white] rounded-b-md">
                <div class="p-9">
                    <div class="text-slate-700">
                        @if(\Filament\Facades\Filament::auth()->user()->garage == 'SP')
                            <img class=" h-150 self-left float-left" src="{{ asset('/assets/images/logo_SP.png') }}" width="150" />
                            <span class="relative left-5"><strong>บริษัท เอส.พี.ภัทร อินเตอร์ทรัค จำกัด</strong></span>
                            <br>
                            <span class="relative left-5">ที่อยู่ : 705 หมู่11 ต.คลองด่าน อ.บางบ่อ จ.สมุทรปราการ 10550</span>
                            <br>
                            <span class="relative left-5">Tel : 0-2707-6199, 02-330-1525  Fax : 02-3301526</span>
                            <br>
                            <span class="relative left-5">Email : sppatr.intertruck@gmail.com</span>
                            <br>
                            <span class="relative left-5">Line ID : @sp2010</span>
                        @endif
                        @if(\Filament\Facades\Filament::auth()->user()->garage == 'SBO')
                            <img class="object-cover h-12 self-left" src="{{ asset('/assets/images/logo_SBO.png') }}" />
                        @endif<div class="flex justify-between">
                            <img class="object-cover h-12 self-left" src="{{ asset('/assets/images/spphat-logo-1.png') }}" />
                            <div class="text-end mt-6">

                            </div>

                        </div>
                        <div class="w-full flex justify-center">
                            <h1 class="text-2xl font-extrabold tracking-tight uppercase font-body">
                                ใบปล่อยรถ
                            </h1>
                        </div>

                        <p class="text-xl mt-6 font-extrabold tracking-tight uppercase font-body">
                            Job No / ทะเบียนรถ : {{ data_get($data, 'job_number', '-') }}
                        </p>
                        <p>
                            เลขที่ปล่อยรถ รหัสอู่ ปี รหัสปล่อยรถ
                        </p>
                    </div>
                </div>
                <div class="px-9">
                    <div class="flex w-full">
                        <div class="w-full grid grid-cols-6 gap-12">
                            <div class="text-lg text-slate-500 col-span-3 space-y-2">
                                <p class="text-lg font-normal text-slate-700">
                                    ชื่อ (ข้าพเจ้า) : {{ data_get($data, 'staff_name', '-') }}
                                </p>
                                <p>
                                    ตำแหน่งที่เกี่ยงข้องกับ บจ./หจก. : {{ data_get($data, 'staff_position', '-') }}
                                </p>
                                <p>
                                    จากบริษัท (SP / SBO) : {{ data_get($data, 'garage', '-') }}
                                </p>
                                <p>
                                    ยี่ห้อรถที่มารับ : {{ data_get($data, 'car_brand', '-') }}
                                </p>
                            </div>
                            <div class="text-lg text-slate-500 col-span-3 space-y-2">
                                <p>
                                    เลขทะเบียน : {{ data_get($data, 'vehicle_registration', '-') }}
                                </p>
                                <p>
                                    เลขกรมธรรม์ : {{ data_get($data, 'insurance_name', '-') }}
                                </p>
                                <p>
                                    ชื่อบริษัทประกันภัยของรถ : {{ data_get($data, 'insurance_name', '-') }}
                                </p>
                                <p>
                                    เลขเคลม / เลขรับแจ้งที่ : {{ data_get($data, 'claim_number', '-') }}
                                </p>
                            </div>
                        </div>
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
