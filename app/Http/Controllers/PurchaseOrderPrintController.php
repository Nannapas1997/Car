<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use Illuminate\Http\Request;

class PurchaseOrderPrintController extends Controller
{
    public function print(Request $request)
    {
        $id = $request->route('id');
        $data = PurchaseOrder::with('purchaseorderitems')->find($id);

        if (!$data) {
            return redirect('/');
        }

        $data = $data->toArray();

        return view('prints.purchase-order', ['data' => $data]);
    }
}
