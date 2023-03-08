<?php

namespace App\Filament\Traits;

use App\Models\CarReceive;
use App\Models\ThailandAddress;
use Closure;
use Filament\Forms\Components\Select;
use Illuminate\Support\Arr;

trait ThailandAddressTrait
{
    public static function searchAddressOptions(Closure $get): array
    {
        $displayAddress = [];
        $address = ThailandAddress::where('zipcode', 'like', '%' . $get('zipcode') . '%')
            ->get()
            ->toArray();
        if ($address) {
            foreach ($address as $val) {
                $displayAddress[Arr::get($val, 'id')] = Arr::get($val, 'zipcode')
                    . ' '
                    . Arr::get($val, 'district')
                    . ' '
                    . Arr::get($val, 'amphoe')
                    . ' '
                    . Arr::get($val, 'province');
            }
        }

        return $displayAddress;
    }

    public static function setValueThailandAddress ($set, $state): void
    {
        if ($state) {
            $address = ThailandAddress::find($state)->toArray();
            if ($address) {
                $set('zipcode', $address['zipcode']);
                $set('district', $address['district']);
                $set('amphoe', $address['amphoe']);
                $set('province', $address['province']);
            }
        }
    }
}
