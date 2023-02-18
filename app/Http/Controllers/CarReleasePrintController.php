<?php

namespace App\Http\Controllers;

use App\Models\CarRelease;
use Illuminate\Http\Request;

class CarReleasePrintController extends Controller
{
    public function print(Request $request)
    {
        $id = $request->route('id');
        $carRelease = CarRelease::find($id);

        if (!$carRelease) {
            return redirect('/');
        }

        $carRelease = $carRelease->toArray();

        return view('prints.car-release', ['data' => $carRelease]);
    }
}
