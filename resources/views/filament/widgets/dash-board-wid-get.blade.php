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

<div class="w-full">
    <div class="days">
        <span class="day">วัน</span>
        <span class="day-code">รหัสความเสียหาย</span>
        <br>
        <span class="day-ten">{{$total}}</span>
        <br>
        <span class="items">รายการ</span>
        <br>
        <span class="code">A</span>
        <span class="count">{{ $a }}</span>
        <span class="item">รายการ</span>
        <br>
        <span class="code">B</span>
        <span class="count">{{ $b }}</span>
        <span class="item">รายการ</span>
        <br>
        <span class="code">C</span>
        <span class="count">{{ $c }}</span>
        <span class="item">รายการ</span>
        <br>
        <span class="code">D</span>
        <span class="count">{{ $d }}</span>
        <span class="item">รายการ</span>
    </div>
</div>


</body>
