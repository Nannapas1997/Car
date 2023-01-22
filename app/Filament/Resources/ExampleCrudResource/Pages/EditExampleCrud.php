<?php

namespace App\Filament\Resources\ExampleCrudResource\Pages;

use App\Filament\Resources\ExampleCrudResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExampleCrud extends EditRecord
{
    protected static string $resource = ExampleCrudResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
