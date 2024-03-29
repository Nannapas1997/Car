<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;

class BillPrintController extends Controller
{
    public function print(Request $request)
    {
        $id = $request->route('id');
        $data = Bill::find($id);

        if (!$data) {
            return redirect('/');
        }

        $data = $data->toArray();

        return view('prints.bill', ['data' => $data]);
    }
}
