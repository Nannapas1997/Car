<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/global.css')}}"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
</head>
<body>
<div class="mx">

    <div class="all-items ">
        <span>รายการทั้งหมด</span>
        <br>
        <span>{{$total}}</span>
        <br>
        <span>รายการ</span>
    </div>

    <div class="parent">
        <div class="all-items-1">
            <span>กำลังดำเนินการ</span>
            <br>
            <span>{{$a}}</span>
            <br>
            <span>รายการ</span>
        </div>
    </div>

    <div class="all-items-2">
        <span>สำเร็จ</span>
        <br>
        <span>{{$b}}</span>
        <br>
        <span>รายการ</span>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.3.slim.js" integrity="sha256-DKU1CmJ8kBuEwumaLuh9Tl/6ZB6jzGOBV/5YpNE2BWc=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready( function () {
    $('#table_id').DataTable();
} );
</script>
</body>
</html>

