<?php

namespace App\Http\Controllers;

use App\Models\CarReceive;
use App\Models\CashReceipt;
use App\Models\Quotation;
use Illuminate\Http\Request;

class QuotationPrintController extends Controller
{
    public function print(Request $request)
    {
        $id = $request->route('id');
        $data = Quotation::find($id);
        $car_receive = CarReceive::find($id);
        if (!$data && !$car_receive) {
            return redirect('/');
        }

        $data = $data->toArray();
        $car_receive = $car_receive->toArray();
        return view('prints.quotation', ['data' => $data, 'car_receive' => $car_receive]);
    }
}
