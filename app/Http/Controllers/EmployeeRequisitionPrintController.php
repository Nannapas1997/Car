<?php

namespace App\Http\Controllers;

use App\Models\EmployeeRequisition;
use Illuminate\Http\Request;

class EmployeeRequisitionPrintController extends Controller
{
    public function print(Request $request)
    {
        $id = $request->route('id');
        $data = EmployeeRequisition::with('employeerequisitionitems')->find($id);

        if (!$data) {
            return redirect('/');
        }

        $data = $data->toArray();

        return view('prints.employee-requisition', ['data' => $data]);
    }
}
