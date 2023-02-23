<?php

namespace App\Filament\Resources\ApprovalRequestResource\Pages;

use Filament\Pages\Actions;
use Illuminate\Support\Arr;
use App\Models\ApprovalRequest;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ApprovalRequestResource;

class CreateApprovalRequest extends CreateRecord
{
    protected static string $resource = ApprovalRequestResource::class;
    

}
