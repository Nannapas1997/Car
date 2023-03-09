<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use App\Models\CarReceive;
use App\Models\CashReceipt;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class QuotationPrintController extends Controller
{
    public function print(Request $request)
    {
        $id = $request->route('id');
        $data = Quotation::find($id);
        if (!$data) {
            return redirect('/');
        }

        $data = $data->toArray();
        $carReceive = CarReceive::query()
        ->where('job_number', Arr::get($data, 'job_number'))
        ->first();


        return view('prints.quotation', ['data' => $data, 'carReceive' => $carReceive]);
    }
}
