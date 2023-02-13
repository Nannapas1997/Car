<?php

namespace App\Http\Livewire;

use App\Models\CarReceive;
use Livewire\Component;

class DatePickerComponent extends Component
{
    public $search = '';

    public function render()
    {
        return view('livewire-datepicker::livewire.input-picker', []);
    }
}
