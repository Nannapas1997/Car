<?php

namespace App\Filament\Resources\ExampleCrudResource\Pages;

use App\Filament\Resources\ExampleCrudResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateExampleCrud extends CreateRecord
{
    protected static string $resource = ExampleCrudResource::class;
}