<?php

namespace App\Http\Controllers;

use App\Models\SaveRepairCost;
use Illuminate\Http\Request;

class SaveRepairCostPrintController extends Controller
{
    public function print(Request $request)
    {
        $id = $request->route('id');
        $data = SaveRepairCost::find($id);

        if (!$data) {
            return redirect('/');
        }

        $data = $data->toArray();

        return view('prints.save-repair-cost', ['data' => $data]);
    }
}
