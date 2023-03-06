<?php

namespace App\Http\Controllers;

use App\Models\CashReceipt;
use Illuminate\Http\Request;

class CashReceiptPrintController extends Controller
{
    public function print(Request $request)
    {
        $id = $request->route('id');
        $data = CashReceipt::find($id);

        if (!$data) {
            return redirect('/');
        }

        $data = $data->toArray();

        return view('prints.cash-receipt', ['data' => $data]);
    }
}
