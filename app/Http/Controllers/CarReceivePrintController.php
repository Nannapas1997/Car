<?php

namespace App\Http\Controllers;

use App\Models\CarReceive;
use Illuminate\Http\Request;

class CarReceivePrintController extends Controller
{
    public function carReceive(Request $request) {
        $id = $request->route('id');
        $carReceive = CarReceive::find($id);

        if (!$carReceive) {
            return redirect('/');
        }

        $carReceive = $carReceive->toArray();

        // $carReceive['id']
        // $carReceive->id

        return view('prints.car-receive', ['data' => $carReceive]);
    }
}
