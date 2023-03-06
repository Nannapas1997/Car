<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;

class BillPrintController extends Controller
{
    public function print(Request $request)
    {
        $id = $request->route('id');
        $bill = Bill::find($id);

        if (!$bill) {
            return redirect('/');
        }

        $bill = $bill->toArray();

        return view('prints.bill', ['data' => $bill]);
    }
}
