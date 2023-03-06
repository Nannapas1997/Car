<?php

namespace App\Http\Controllers;

use App\Models\PriceControlBills;
use Illuminate\Http\Request;

class PriceControlBillPrintController extends Controller
{
    public function print(Request $request)
    {
        $id = $request->route('id');
        $data = PriceControlBills::find($id);

        if (!$data) {
            return redirect('/');
        }

        $data = $data->toArray();

        return view('prints.price-control-bill', ['data' => $data]);
    }
}
