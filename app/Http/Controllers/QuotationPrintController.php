<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use App\Models\CarReceive;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class QuotationPrintController extends Controller
{
    public function print(Request $request)
    {
        $id = $request->route('id');
        $data = Quotation::with('quotationitems')->find($id);
        if (!$data) {
            return redirect('/');
        }

        $data = $data->toArray();
        $carReceive = CarReceive::query()
        ->where('job_number', Arr::get($data, 'job_number'))
        ->first();

        $carReceive = $carReceive->toArray();

        return view('prints.quotation', ['data' => $data, 'carReceive' => $carReceive]);
    }
}
