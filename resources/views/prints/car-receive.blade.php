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
</head>

<body class="">
<body class="">
    <section class="bg-white">
        <div class="max-w-5xl mx-auto">
            <article class="overflow-hidden">
                <div class="bg-[white] rounded-b-md">
                    <div class="p-9">
                        <div class="space-y-6 text-slate-700">
                            <div class="container mx-auto">
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
                                    @endif

                            </div>

                            <div class="flex text-start justify-between">
                                    <p>
                                        เลขที่ {{ data_get($data, 'job_number', 'NULL') }}
                                    </p>
                                    <p>

                                    </p>
                                    <p>วันที่รับเรื่อง {{ data_get($data, 'receive_date', 'NULL') }} &nbsp;&nbsp;เวลา {{ data_get($data, 'timex', 'NULL') }} น.</p>
                            </div>
                        </div>
                    </div>
                    <h1 class="title-car-receive relative bottom-5">ใบรับรถ สั่งซ่อม</h1>
                    <div class="px-9">
                        <div class="w-full">
                            <div class="">
                                <div class=" flex justify-between ">
                                    <p class="font-normal text-slate-700 float-left">
                                        เจ้าของรถ : {{ data_get($data, 'customer', NULL) }}
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
                        <div class="w-full">
                            <div class="flex">
                                <p class="relative top-3">รถประกัน</p>

                                <input type="radio" class="relative top-4 left-4 insurance" id="name" name="insurance" value="{{ data_get($data, 'options', NULL) }}" class="font-normal text-slate-700 relative top-6" disabled checked>
                                <label for="name" class="relative top-3 left-6">เคลมประกันบริษัท : {{ data_get($data, 'insu_company_name', NULL) }}</label>
                                <?php  $value = data_get($data, 'insu_company_name', NULL)   ?>
                                @if($value === NULL)
                                <input type="radio" class="relative top-4 left-9 insurance" id="cash" name="insurance" value="{{ data_get($data, 'options', NULL) }}" class="font-normal text-slate-700 relative top-6" disabled checked>
                                <label for="cash" class="relative top-3 left-11">เงินสด</label>
                                @else
                                <input type="radio" class="relative top-4 left-9 insurance" id="cash" name="insurance" value="{{ data_get($data, 'options', NULL) }}" class="font-normal text-slate-700 relative top-6" disabled>
                                <label for="cash" class="relative top-3 left-11">เงินสด</label>
                                @endif
                            </div>
                        </div>
                        <div class="w-full">
                            <div class="flex">
                                <p class="relative top-4">จอดซ่อม</p>
                                <input type="radio" id="park" name="park" value="{{ data_get($data, 'park_type', NULL) }}" class="font-normal text-slate-700 relative" disabled checked>
                                <label for="park" class="relative top-4 left-6">จอดซ่อม</label>
                                <?php  $value = data_get($data, 'park_type', NULL)   ?>
                                @if($value === NULL)
                                <input type="radio" id="park-type" name="park" value="{{ data_get($data, 'park_type', NULL) }}" class="font-normal text-slate-700 relative car-park" disabled checked>
                                <label for="park-type" class="relative left-11 car-park">ไม่จอดซ่อม</label>
                                @else
                                <input type="radio" id="park-type" name="park" value="{{ data_get($data, 'park_type', NULL) }}" class="font-normal text-slate-700 relative car-park" disabled>
                                <label for="park-type" class="relative left-11 car-park">ไม่จอดซ่อม</label>
                                @endif
                                <p class="text-end self-left mile">เลขไมล์ : {{ data_get($data, 'mile_number', NULL) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-9 content">
                        <div class="flex flex-col mx-0 mt-8">
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
                                <tr class="">
                                    <td class="py-4 pl-4 pr-3 text-sm sm:pl-6 md:pl-0 content-1">
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
                                        <div class="float-left">
                                            @if($spare_tire !== NULL && $spare_tire === 1)
                                            <input type="checkbox" id="spare_tire" name="spare_tire" class="relative left-10" value="" disabled checked>
                                            <label for="spare_tire" class="relative bottom-1 left-10">ยางอะไหล่</label><br>
                                            @else
                                            <input type="checkbox" id="jack_handle" name="jack_handle" value="" disabled>
                                            <label for="jack_handle" class="relative bottom-1">ยางอะไหล่</label><br>
                                            @endif
                                        </div>
                                        <div class="float-left">
                                            @if($jack_handle !== NULL && $jack_handle === 1)
                                            <input type="checkbox" id="jack_handle" name="jack_handle" value="" class="relative left-14 " disabled checked>
                                            <label for="jack_handle" class="relative bottom-1 left-14">แม่แรง+ด้าม</label><br>
                                            @else
                                            <input type="checkbox" id="jack_handle" name="jack_handle" value="" class="relative left-14 " disabled>
                                            <label for="jack_handle" class="relative bottom-1 left-14">แม่แรง+ด้าม</label><br>
                                            @endif
                                        </div>
                                        <div class="float-none">
                                            @if($boxset !== NULL && $boxset === 1)
                                            <input type="checkbox" id="boxset" name="boxset" value="" class="relative top-6" disabled checked>
                                            <label for="boxset" class="relative bottom-1 boxset">ชุดเครื่องมือ คีม, ประแจ, ไขควง</label><br>
                                            @else
                                            <input type="checkbox" id="boxset" name="boxset" value="" class="relative top-6" disabled>
                                            <label for="boxset" class="relative bottom-1 boxset">ชุดเครื่องมือ คีม, ประแจ, ไขควง</label><br>
                                            @endif
                                        </div>
                                        <div class="float-left">
                                            @if($batteries !== NULL && $batteries === 1)
                                            <input type="checkbox" id="boxset" name="batteries" value="" class="relative left-10" disabled checked>
                                            <label for="batteries" class="relative bottom-1 left-11">แบตเตอรี่</label><br>
                                            @else
                                            <input type="checkbox" id="batteries" name="batteries" value="" class="relative left-10" disabled>
                                            <label for="batteries" class="relative bottom-1 left-11">แบตเตอรี่</label><br>
                                            @endif
                                        </div>
                                        <div class="float-none">
                                            @if($cigarette_lighter !== NULL && $cigarette_lighter === 1)
                                            <input type="checkbox" id="cigarette_lighter" name="cigarette_lighter" value="" class="relative" disabled checked>
                                            <label for="cigarette_lighter" class="relative bottom-1 cigarette_lighter">ที่จุดบุหรี่</label><br>
                                            @else
                                            <input type="checkbox" id="cigarette_lighter" name="cigarette_lighter" value="" class="relative" disabled>
                                            <label for="cigarette_lighter" class="relative bottom-1 cigarette_lighter">ที่จุดบุหรี่</label><br>
                                            @endif
                                        </div>
                                        <div class="float-left">
                                            @if($radio !== NULL && $radio === 1)
                                            <input type="checkbox" id="radio" name="radio" value="" class="relative" disabled checked>
                                            <label for="radio" class="relative bottom-1 radio">วิทยุ/CD</label><br>
                                            @else
                                            <input type="checkbox" id="radio" name="radio" value="" class="relative" disabled>
                                            <label for="radio" class="relative bottom-1 radio">วิทยุ/CD</label><br>
                                            @endif
                                        </div>
                                        <div class="float-none">
                                            @if($floor_mat !== NULL && $floor_mat === 1)
                                            <input type="checkbox" id="floor_mat" name="floor_mat" value="" class="relative" disabled checked>
                                            <label for="floor_mat" class="relative bottom-1 floor_mat">ผ้ายางปูพื้น</label><br>
                                            @else
                                            <input type="checkbox" id="floor_mat" name="floor_mat" value="" class="relative" disabled>
                                            <label for="floor_mat" class="relative bottom-1 floor_mat">ผ้ายางปูพื้น</label><br>
                                            @endif
                                        </div>
                                        <div class="float-none">
                                            @if($spare_removal !== NULL && $spare_removal === 1)
                                            <input type="checkbox" id="spare_removal" name="floor_mat" value="" class="relative" disabled checked>
                                            <label for="spare_removal" class="relative bottom-1 spare_removal">ชุดถอดยางอะไหล่</label><br>
                                            @else
                                            <input type="checkbox" id="spare_removal" name="spare_removal" value="" class="relative" disabled>
                                            <label for="spare_removal" class="relative bottom-1 spare_removal">ชุดถอดยางอะไหล่</label><br>
                                            @endif
                                        </div>
                                        <div class="float-left">
                                            @if($fire_extinguisher !== NULL && $fire_extinguisher === 1)
                                            <input type="checkbox" id="fire_extinguisher" name="fire_extinguisher" value="" class="relative" disabled checked>
                                            <label for="fire_extinguisher" class="relative bottom-1 fire_extinguisher">ถังดับเพลิง</label><br>
                                            @else
                                            <input type="checkbox" id="fire_extinguisher" name="fire_extinguisher" value="" class="relative" disabled>
                                            <label for="fire_extinguisher" class="relative bottom-1 fire_extinguisher">ถังดับเพลิง</label><br>
                                            @endif
                                        </div>
                                        <div class="float-none">
                                            @if($spining_wheel !== NULL && $spining_wheel === 1)
                                            <input type="checkbox" id="spining_wheel" name="spining_wheel" value="" class="relative" disabled checked>
                                            <label for="spining_wheel" class="relative bottom-1 spining_wheel">ไม้หมุนล้อ</label><br>
                                            @else
                                            <input type="checkbox" id="spining_wheel" name="spining_wheel" value="" class="relative" disabled>
                                            <label for="spining_wheel" class="relative bottom-1 spining_wheel">ไม้หมุนล้อ</label><br>
                                            @endif
                                        </div>
                                        <div class="float-none">
                                            @if($other !== NULL && $other === 1)
                                            <input type="checkbox" id="other" name="other" value="" class="relative" disabled checked>
                                            <label for="other" class="relative bottom-1 other">อื่น ๆ</label><br>
                                            <input type="text">
                                            @else
                                            <input type="checkbox" id="other" name="other" value="" class="relative" disabled>
                                            <label for="other" class="relative bottom-1 other">อื่น ๆ</label><br>
                                            @endif
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
                                    <td class="py-4 pl-4 pr-3  sm:pl-6 md:pl-0">
                                        <div class="font-medium text-slate-700">

                                        </div>
                                        <div class="mt-0.5 text-slate-700">

                                        </div>
                                    </td>
                                    <td class="px-3 py-4 text-right text-slate-700 sm:table-cell">

                                    </td>
                                    <td class="hidden px-3 py-4 text-sm text-right text-slate-500 sm:table-cell">

                                    </td>
                                    <td class="py-4 pl-3 pr-4 text-sm text-right text-slate-500 sm:pr-6 md:pr-0">

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
