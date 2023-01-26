<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/global.css')}}"/>
</head>
<body>
<div class="w-full text-gray-800 space-y-4">
    <div class="flex justify-center px-3 py-1 bg-white items-center gap-1 rounded-lg border border-gray-100 my-3">
        <div>
            <h1 class="font-semibold text-2xl">Total : {{ $total }}</h1>
        </div>
    </div>

    @foreach($data as $item)
        @php
            $imageUrl = env('APP_URL') . '/assets/images/icon-file.png';
            $fileArr = explode('.', data_get($item, 'image_url_1'));
        @endphp

        @if (count($fileArr) == 2)
            @if ($fileArr[1] == 'jpg' || $fileArr[1] == 'png' || $fileArr[1] == 'jpeg')
                @php
                    $imageUrl = env('APP_URL') . '/storage/' . data_get($item, 'image_url_1');
                @endphp
            @endif
        @endif
        <div class="flex px-3 py-1 bg-white items-center gap-1 rounded-lg border border-gray-100 my-3">
            <div class="relative w-16 h-16 rounded-full hover:bg-red-700 bg-gradient-to-r from-purple-400 via-blue-500 to-red-400 ">
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-14 h-14 bg-gray-200 rounded-full border-2 border-white">
                    <img
                        class="w-full h-full object-cover rounded-full"
                        src="{{ $imageUrl }}"
                        alt=""
                    />
                </div>
            </div>
            <div>
                <span class="">{{data_get($item, 'name')}}</span>
            </div>
        </div>
    @endforeach

</div>
<div class="w-full">
    <div class="days">
        <span class="day">วัน</span>
        <span class="day-code">รหัสความเสียหาย</span>
        <br>
        <span class="day-ten">10</span>
        <span class="code">A</span>
        <span class="items">3 รายการ</span>

        <br>
        <span class="code-2">B</span>
        <span class="items-2">2 รายการ</span>
        <br>
        <span class="code-3">C</span>
        <span class="items-3">1 รายการ</span>
        <br>
        <span class="code-4">D</span>
        <span class="items-4">4 รายการ</span>
        <span class="item">รายการ</span>
        <div class="left"></div>

    </div>
</div>


</body>
