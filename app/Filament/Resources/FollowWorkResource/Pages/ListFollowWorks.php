<?php

namespace App\Filament\Resources\FollowWorkResource\Pages;

use App\Filament\Resources\FollowWorkResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFollowWorks extends ListRecords
{
    protected static string $resource = FollowWorkResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
