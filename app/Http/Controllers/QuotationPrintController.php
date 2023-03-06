<?php

namespace App\Http\Controllers;

use App\Models\CashReceipt;
use App\Models\Quotation;
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

        return view('prints.quotation', ['data' => $data]);
    }
}
