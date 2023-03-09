<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use Illuminate\Http\Request;

class PurchaseOrderPrintController extends Controller
{
    public function print(Request $request)
    {
        $id = $request->route('id');
        $data = PurchaseOrder::find($id);

        if (!$data) {
            return redirect('/');
        }

        $data = $data->toArray();
        dd($data);
        return view('prints.purchase-order', ['data' => $data]);
    }
}
