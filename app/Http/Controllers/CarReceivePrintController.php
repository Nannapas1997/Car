<?php

namespace App\Http\Controllers;

use App\Models\CarReceive;
use Illuminate\Http\Request;

class CarReceivePrintController extends Controller
{
    public function index(Request $request) {
        $carReceive = CarReceive::find($request->route('id'))->toArray();

        if (!$carReceive) {
            return redirect('/');
        }

        return view('prints.car-receive', ['data' => $carReceive]);
    }
}
