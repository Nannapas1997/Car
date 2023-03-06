<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoicePrintController extends Controller
{
    public function print(Request $request)
    {
        $id = $request->route('id');
        $invoice = Invoice::with('invoiceItems')->find($id);

        if (!$invoice) {
            return redirect('/');
        }

        $invoice = $invoice->toArray();

        return view('prints.invoice', ['data' => $invoice]);
    }
}
