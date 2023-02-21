<?php

namespace Database\Seeders;

use App\Models\ThailandAddress;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Seeder;

class ThailandAddressSeeder extends Seeder
{
    public function run()
    {
        $thaiAddress = json_decode(Storage::get('thaiAddress.json'), true);
        $this->command->getOutput()->progressStart(count($thaiAddress));
        foreach ($thaiAddress as $val) {
            ThailandAddress::create([
                'province' => Arr::get($val, 'province'),
                'amphoe' => Arr::get($val, 'amphoe'),
                'district' => Arr::get($val, 'district'),
                'zipcode' => Arr::get($val, 'zipcode'),
            ]);
            $this->command->getOutput()->progressAdvance();
        }

        $this->command->getOutput()->progressFinish();
    }
}
