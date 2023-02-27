<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $pollingInterval = '60s';

    protected static function getNavigationLabel(): string
    {
        return 'หน้าแรก';
    }

    protected function getTitle(): string
    {
        return '';
    }

    protected function getActions(): array
    {
        return [
        ];
    }

    protected function getViewData(): array
    {
        return [
        ];
    }
}
