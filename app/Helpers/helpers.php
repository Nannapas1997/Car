<?php

use Carbon\Carbon;

if (! function_exists('convertYmdToThai')) {
    function convertYmdToThai($date)
    {
        $day = Carbon::createFromFormat('Y-m-d', $date)->format('d');
        $monthNum = Carbon::createFromFormat('Y-m-d', $date)->format('m');
        $year = Carbon::createFromFormat('Y-m-d', $date)->format('Y');
        $year = intval($year) + 543;
        $monthStr = '';

        switch ($monthNum) {
            case '01':
                $monthStr = 'มกราคม';
                break;
            case '02':
                $monthStr = 'กุมภาพันธ์';
                break;
            case '03':
                $monthStr = 'มีนาคม';
                break;
            case '04':
                $monthStr = 'เมษายน';
                break;
            case '05':
                $monthStr = 'พฤษภาคม';
                break;
            case '06':
                $monthStr = 'มิถุนายน';
                break;
            case '07':
                $monthStr = 'กรกฎาคม';
                break;
            case '08':
                $monthStr = 'สิงหาคม';
                break;
            case '09':
                $monthStr = 'กันยายน';
                break;
            case '10':
                $monthStr = 'ตุลาคม';
                break;
            case '11':
                $monthStr = 'พฤศจิกายน';
                break;
            case '12':
                $monthStr = 'ธันวาคม';
                break;
        }

        return "{$day} {$monthStr} พ.ศ. {$year}";
    }
}
