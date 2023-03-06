<?php

namespace App\Http\Controllers;

use App\Models\Requisition;
use Illuminate\Http\Request;

class RequisitionPrintController extends Controller
{
    public function print(Request $request)
    {
        $id = $request->route('id');
        $data = Requisition::find($id);

        if (!$data) {
            return redirect('/');
        }

        $data = $data->toArray();

        return view('prints.requisition', ['data' => $data]);
    }
}
