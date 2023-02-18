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

if (! function_exists('convertYmdToThaiShort')) {
    function convertYmdToThaiShort($date)
    {
        if ($date) {
            $day = Carbon::createFromFormat('Y-m-d', $date)->format('d');
            $monthNum = Carbon::createFromFormat('Y-m-d', $date)->format('m');
            $year = Carbon::createFromFormat('Y-m-d', $date)->format('Y');
            $year = intval($year) + 543;
            $monthStr = '';

            switch ($monthNum) {
                case '01':
                    $monthStr = 'ม.ค.';
                    break;
                case '02':
                    $monthStr = 'ก.พ.';
                    break;
                case '03':
                    $monthStr = 'มี.ค.';
                    break;
                case '04':
                    $monthStr = 'เม.ย.';
                    break;
                case '05':
                    $monthStr = 'พ.ค.';
                    break;
                case '06':
                    $monthStr = 'มิ.ย.';
                    break;
                case '07':
                    $monthStr = 'ก.ค.';
                    break;
                case '08':
                    $monthStr = 'ส.ค.';
                    break;
                case '09':
                    $monthStr = 'ก.ย.';
                    break;
                case '10':
                    $monthStr = 'ต.ค.';
                    break;
                case '11':
                    $monthStr = 'พ.ย.';
                    break;
                case '12':
                    $monthStr = 'ธ.ค.';
                    break;
            }

            return "{$day} {$monthStr} {$year}";
        }

        return "-";
    }
}

if (! function_exists('convertHisToHi')) {
    function convertHisToHi($time)
    {
        if ($time) {
            $timeArr = explode(':', $time);

            return "{$timeArr[0]}:{$timeArr[1]} น.";
        }

        return '-';
    }
}
