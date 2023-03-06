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
                                <span class="relative"><strong>ลูกต้า</strong></span>
                                <br>
                                <span class="relative">{{ data_get($data, 'customer') }}</span>
                            </div>
                            <div class="flex-1 pt-10 ml-20">
                                <div class="flex justify-center">
                                    <h1 class="text-4xl">ใบแจ้งหนี้</h1>
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
                                        <p>{{ data_get($data, 'invoice_number', '-') }}</p>
                                    </div>
                                    <div class="col-span-2">
                                        <p class="font-semibold">วันที่</p>
                                    </div>
                                    <div class="col-span-3">
                                        <p>{{ convertYmdToThaiNumber(\Carbon\Carbon::now()->format('Y-m-d')) }}</p>
                                    </div>
                                    <div class="col-span-2">
                                        <p class="font-semibold">ครบกำหนด</p>
                                    </div>
                                    <div class="col-span-3">
                                        <p>-</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="p-9 content">
                        <div class="flex flex-col mx-0 mt-8">
                            <table class="w-full border border-collapse border-slate-500">
                                <thead class="border">
                                <tr class="text-sm">
                                    <th scope="col" class="text-center border w-[20px]">
                                        ลำดับ
                                    </th>
                                    <th scope="col" class="text-center border">
                                        รายการ
                                    </th>
                                    <th scope="col" class="text-center border">
                                        จำนวนเงิน
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach(data_get($data, 'invoice_items') as $idx => $item)
                                    <tr class="gap-2 text-small-f">
                                        <td class="text-center border p-2">
                                            {{ $idx + 1 }}
                                        </td>
                                        <td class="text-center border p-2">
                                            {{ data_get($item, 'spare_code') ?? '-' }}
                                        </td>
                                        <td class="text-center border p-2">
                                            {{ data_get($item, 'price') ?? '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                                    <tr class="gap-2">
                                        <td colspan="2" class="flex-col border py-4 px-6">
                                            <p>หมายเหตุ</p>
                                            <p>ใบกำกับภาษีและใบเสร็จรับเงินจะออกให้ ณ วันที่รับเงิน</p>
                                        </td>
                                        <td colspan="1" class="flex-col border py-4 px-6">
                                            <p class="flex justify-between">
                                                <span>รวม</span>
                                                <span>{{ data_get($data, 'amount', '-') }}</span>
                                            </p>
                                            <p class="flex justify-between">
                                                <span>ส่วนลด</span>
                                                <span>-</span>
                                            </p>
                                            <p class="flex justify-between">
                                                <span>คงเหลือ</span>
                                                <span>{{ data_get($data, 'amount', '-') }}</span>
                                            </p>
                                            <p class="flex justify-between">
                                                <span>ภาษีมูลค่าเพิ่ม 7%</span>
                                                <span>{{ data_get($data, 'vat', '-') }}</span>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr class="gap-2">
                                        <td colspan="2" class="flex-col border py-4 px-6">
                                            <p>&nbsp;</p>
                                        </td>
                                        <td colspan="1" class="flex-col border py-4 px-6">
                                            <p class="flex justify-between">
                                                <span>สุทธิ</span>
                                                <span>{{ data_get($data, 'aggregate', '-') }}</span>
                                            </p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="p-9 content">
                    <div class="grid grid-cols-2">
                        <div class="w-full text-center">
                            <div class="border-b mx-20 mt-10"></div>
                            <div class="border-b mx-20 flex justify-between mt-4">
                                <p>(</p>
                                <p>)</p>
                            </div>
                            <div class="border-b mx-20 flex justify-between mt-4">
                                <p>วันที่</p>
                                <p>/</p>
                                <p>/</p>
                                <p>/</p>
                            </div>
                            <p class="pt-2">ผู้รับสินค้า</p>
                        </div>
                        <div class="w-full text-center">
                            <div class="border-b mx-20 mt-10"></div>
                            <div class="border-b mx-20 flex justify-between mt-4">
                                <p>(</p>
                                <p>)</p>
                            </div>
                            <div class="border-b mx-20 flex justify-between mt-4">
                                <p>วันที่</p>
                                <p>/</p>
                                <p>/</p>
                                <p>/</p>
                            </div>
                            <p class="pt-2">ผู้มีอำนาจลงนาม</p>
                            <div class="">บริษัท เอส.พี.ภัทร อินเตอร์ ทรัค จำกัด</div>
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
