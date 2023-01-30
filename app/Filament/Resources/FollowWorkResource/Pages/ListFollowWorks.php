<?php

namespace App\Filament\Resources\FollowWorkResource\Pages;

use App\Models\CarReceive;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\FollowWorkResource;

class ListFollowWorks extends ListRecords
{
    protected static string $resource = FollowWorkResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            FollowWorkResource\Widgets\FollowWork::class,
        ];
    }
   
}
