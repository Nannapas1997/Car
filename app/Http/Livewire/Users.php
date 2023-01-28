<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Filament\Tables;

class Users extends Component implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected function getTableQuery()
    {
        return \App\Models\User::query();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name'),
            Tables\Columns\TextColumn::make('email'),
        ];
    }

    public function render()
    {
        return view('livewire.users');
    }
}
