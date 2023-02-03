<?php

namespace App\Filament\Resources\CarReceiveResource\Pages;

use App\Filament\Resources\CarReceiveResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCarReceive extends EditRecord
{
    protected static string $resource = CarReceiveResource::class;


    public function deleteAny() {
        return true;
    }
    public function forceDelete() {
        return false;
    }
    public function forceDeleteAny() {
        return false;
    }
}
