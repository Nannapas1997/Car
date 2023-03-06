<?php

use Carbon\Carbon;
use Illuminate\Support\Arr;

if (! function_exists('convertYmdToThai')) {
    function convertYmdToThai($date): string
    {
        if ($date) {
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

        return '-';
    }
}

if (! function_exists('convertYmdToThaiNumber')) {
    function convertYmdToThaiNumber($date): string
    {
        if ($date) {
            $day = Carbon::createFromFormat('Y-m-d', $date)->format('d');
            $year = Carbon::createFromFormat('Y-m-d', $date)->format('Y');
            $year = intval($year) + 543;
            $monthStr = Carbon::createFromFormat('Y-m-d', $date)->format('m');

            return "{$day}/{$monthStr}/{$year}";
        }

        return '-';
    }
}

if (! function_exists('convertYmdToThaiShort')) {
    function convertYmdToThaiShort($date): string
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

if (! function_exists('convertYmdHisToThaiShort')) {
    function convertYmdHisToThaiShort($date): string
    {
        if ($date) {
            $time = Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('H:i น.');
            $day = Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d');
            $monthNum = Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('m');
            $year = Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y');
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

            return "{$day} {$monthStr} {$year} {$time}";
        }

        return "-";
    }
}

if (! function_exists('convertHisToHi')) {
    function convertHisToHi($time): string
    {
        if ($time) {
            $timeArr = explode(':', $time);

            return "{$timeArr[0]}:{$timeArr[1]} น.";
        }

        return '-';
    }
}

if (! function_exists('helperGetYearList')) {
    function helperGetYearList(): array
    {
        $currentYear = intval(now()->format('Y'));
        $options = [];

        while ($currentYear > 1999) {
            $options[$currentYear] = $currentYear;
            $currentYear--;
        }
        return $options;
    }
}

if (! function_exists('calVat')) {
    function calVat($num, $chooseVat = 'vat_include_yes'): string
    {
        $vat = 0;

        if ($chooseVat == 'vat_include_yes' && is_numeric($num)) {
            $vat = $num * (7/100);
        }

        return $vat ? number_format(str_replace(',', '', $vat), 2) : '0.00';
    }
}

if (! function_exists('calTotalIncludeVat')) {
    function calTotalIncludeVat($num, $chooseVat = 'vat_include_yes'): string
    {
        $total = 0;

        if ($chooseVat == 'vat_include_yes' && is_numeric($num)) {
            $vat = $num * (7/100);
            $total = $num + $vat;
        }

        return $total ? number_format(str_replace(',', '', $total), 2) : '0.00';
    }
}

if (! function_exists('calVatItems')) {
    function calVatItems($items, $key, $chooseVat = 'vat_include_yes', $qty = 1): string
    {
        $total = 0;
        $vat = 0;

        if (!$items) {
            return '0.00';
        }

        foreach ($items as $item) {
            if(Arr::get($item, $key)) {
                $total += (Arr::get($item, $key) * $qty);
            }
        }

        if ($chooseVat == 'vat_include_yes') {
            $vat = $total * (7/100);
        }

        return $vat ? number_format(str_replace(',', '', $vat), 2) : '0.00';
    }
}

if (! function_exists('calTotalItems')) {
    function calTotalItems($items, $key, $chooseVat = 'vat_include_yes', $qty = 1): string
    {
        $total = 0;
        $vat = 0;

        if (!$items) {
            return '0.00';
        }

        foreach ($items as $item) {
            if(Arr::get($item, $key)) {
                $total += (Arr::get($item, $key) * $qty);
            }
        }

        if ($chooseVat == 'vat_include_yes') {
            $vat = $total * (7/100);
        }

        $total = $total + $vat;


        return $total ? number_format(str_replace(',', '', $total), 2) : '0.00';
    }
}

if (! function_exists('calTotalWageItems')) {
    function calTotalWageItems($items, $key, $chooseVat = 'vat_include_yes', $qty = 1): string
    {
        $total = 0;
        $vat = 0;

        if (!$items) {
            return '0.00';
        }

        foreach ($items as $item) {
            if (Arr::get($item, $key) && Arr::get($item, 'spare_code') == 'C6') {
                $total += (Arr::get($item, $key) * $qty);
            }
        }

        if ($chooseVat == 'vat_include_yes') {
            $vat = $total * (7/100);
        }

        $total = $total + $vat;


        return $total ? number_format(str_replace(',', '', $total), 2) : '0.00';
    }
}

if (! function_exists('calTotalExcludeWageItems')) {
    function calTotalExcludeWageItems($items, $key, $chooseVat = 'vat_include_yes', $qty = 1): string
    {
        $total = 0;
        $vat = 0;

        if (!$items) {
            return '0.00';
        }

        foreach ($items as $item) {
            $quantity = Arr::get($item, 'quantity', $qty);

            if(
                Arr::get($item, $key) &&
                Arr::get($item, 'spare_code') != 'C6'
            ) {
                $total += Arr::get($item, $key) * $quantity;
            }
        }

        if ($chooseVat == 'vat_include_yes') {
            $vat = $total * (7/100);
        }

        $total = $total + $vat;


        return $total ? number_format(str_replace(',', '', $total), 2) : '0.00';
    }
}
