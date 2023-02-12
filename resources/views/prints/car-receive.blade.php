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
                        <div class="space-y-6 text-slate-700">
                            <div class="flex justify-between">
                                <img class="object-cover h-12 self-left" src="{{ asset('/assets/images/spphat-logo-1.png') }}" />
                                <div class="text-end">
                                    <h1 class="text-2xl font-extrabold tracking-tight uppercase font-body">
                                        เอกสารรับรถ
                                    </h1>
                                    <p>
                                        เลขที่ {{ data_get($data, 'job_number', 'NULL') }}
                                    </p>
                                </div>

                            </div>
                            <p class="text-xl font-extrabold tracking-tight uppercase font-body">
                                spphat-intertruck.co.th
                            </p>
                        </div>
                    </div>
                    <div class="px-9">
                        <div class="flex w-full">
                            <div class="w-full grid grid-cols-4 gap-12">
                                <div class="text-sm font-light text-slate-500 col-span-2">
                                    <p class="text-sm font-normal text-slate-700">
                                        เจ้าของรถ : {{ data_get($data, 'customer') }}
                                    </p>
                                    <p>
                                        เบอร์โทร : {{ data_get($data, 'tel_number') }}
                                    </p>
                                    <p>
                                        ยี่ห้อง : {{ data_get($data, 'brand') }} (รุ่น {{ data_get($data, 'model', '-') }})
                                    </p>
                                    <p>
                                        ไมล์หน้ารถ : {{ data_get($data, 'mile_number') }}
                                    </p>
                                    <p>
                                        ประเภทซ่อม : {{ data_get($data, 'repair_code') }}
                                    </p>
                                </div>
                                <div class="text-sm font-light text-slate-500 col-span-2">
                                    <p class="text-sm font-normal text-slate-700">
                                        อู่ : {{ data_get($data, 'choose_garage') }}
                                    </p>
                                    <p>000000</p>

                                    <p class="mt-2 text-sm font-normal text-slate-700">
                                        วันรับเรื่อง
                                    </p>
                                    <p>{{ convertYmdToThai(data_get($data, 'receive_date')) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-9">
                        <div class="flex flex-col mx-0 mt-8">
                            <table class="min-w-full divide-y divide-slate-500">
                                <thead>
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-normal text-slate-700 sm:pl-6 md:pl-0">
                                        Description
                                    </th>
                                    <th scope="col" class="hidden py-3.5 px-3 text-right text-sm font-normal text-slate-700 sm:table-cell">
                                        Quantity
                                    </th>
                                    <th scope="col" class="hidden py-3.5 px-3 text-right text-sm font-normal text-slate-700 sm:table-cell">
                                        Rate
                                    </th>
                                    <th scope="col" class="py-3.5 pl-3 pr-4 text-right text-sm font-normal text-slate-700 sm:pr-6 md:pr-0">
                                        Amount
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="border-b border-slate-200">
                                    <td class="py-4 pl-4 pr-3 text-sm sm:pl-6 md:pl-0">
                                        <div class="font-medium text-slate-700">Tesla Truck</div>
                                        <div class="mt-0.5 text-slate-500 sm:hidden">
                                            1 unit at $0.00
                                        </div>
                                    </td>
                                    <td class="hidden px-3 py-4 text-sm text-right text-slate-500 sm:table-cell">
                                        48
                                    </td>
                                    <td class="hidden px-3 py-4 text-sm text-right text-slate-500 sm:table-cell">
                                        $0.00
                                    </td>
                                    <td class="py-4 pl-3 pr-4 text-sm text-right text-slate-500 sm:pr-6 md:pr-0">
                                        $0.00
                                    </td>
                                </tr>
                                <tr class="border-b border-slate-200">
                                    <td class="py-4 pl-4 pr-3 text-sm sm:pl-6 md:pl-0">
                                        <div class="font-medium text-slate-700">
                                            Tesla Charging Station
                                        </div>
                                        <div class="mt-0.5 text-slate-500 sm:hidden">
                                            1 unit at $75.00
                                        </div>
                                    </td>
                                    <td class="hidden px-3 py-4 text-sm text-right text-slate-500 sm:table-cell">
                                        4
                                    </td>
                                    <td class="hidden px-3 py-4 text-sm text-right text-slate-500 sm:table-cell">
                                        $0.00
                                    </td>
                                    <td class="py-4 pl-3 pr-4 text-sm text-right text-slate-500 sm:pr-6 md:pr-0">
                                        $0.00
                                    </td>
                                </tr>

                                <!-- Here you can write more products/tasks that you want to charge for-->
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th scope="row" colspan="3" class="hidden pt-6 pl-6 pr-3 text-sm font-light text-right text-slate-500 sm:table-cell md:pl-0">
                                        Subtotal
                                    </th>
                                    <th scope="row" class="pt-6 pl-4 pr-3 text-sm font-light text-left text-slate-500 sm:hidden">
                                        Subtotal
                                    </th>
                                    <td class="pt-6 pl-3 pr-4 text-sm text-right text-slate-500 sm:pr-6 md:pr-0">
                                        $0.00
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" colspan="3" class="hidden pt-6 pl-6 pr-3 text-sm font-light text-right text-slate-500 sm:table-cell md:pl-0">
                                        Discount
                                    </th>
                                    <th scope="row" class="pt-6 pl-4 pr-3 text-sm font-light text-left text-slate-500 sm:hidden">
                                        Discount
                                    </th>
                                    <td class="pt-6 pl-3 pr-4 text-sm text-right text-slate-500 sm:pr-6 md:pr-0">
                                        $0.00
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" colspan="3" class="hidden pt-4 pl-6 pr-3 text-sm font-light text-right text-slate-500 sm:table-cell md:pl-0">
                                        Tax
                                    </th>
                                    <th scope="row" class="pt-4 pl-4 pr-3 text-sm font-light text-left text-slate-500 sm:hidden">
                                        Tax
                                    </th>
                                    <td class="pt-4 pl-3 pr-4 text-sm text-right text-slate-500 sm:pr-6 md:pr-0">
                                        $0.00
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" colspan="3" class="hidden pt-4 pl-6 pr-3 text-sm font-normal text-right text-slate-700 sm:table-cell md:pl-0">
                                        Total
                                    </th>
                                    <th scope="row" class="pt-4 pl-4 pr-3 text-sm font-normal text-left text-slate-700 sm:hidden">
                                        Total
                                    </th>
                                    <td class="pt-4 pl-3 pr-4 text-sm font-normal text-right text-slate-700 sm:pr-6 md:pr-0">
                                        $0.00
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="mt-48 p-9">
                        <div class="border-t pt-9 border-slate-200">
                            <div class="text-sm font-light text-slate-700">
                                <p>
                                    Payment terms are 14 days. Please be aware that according to the
                                    Late Payment of Unwrapped Debts Act 0000, freelancers are
                                    entitled to claim a 00.00 late fee upon non-payment of debts
                                    after this time, at which point a new invoice will be submitted
                                    with the addition of this fee. If payment of the revised invoice
                                    is not received within a further 14 days, additional interest
                                    will be charged to the overdue account and a statutory rate of
                                    8% plus Bank of England base of 0.5%, totalling 8.5%. Parties
                                    cannot contract out of the Act’s provisions.
                                </p>
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
