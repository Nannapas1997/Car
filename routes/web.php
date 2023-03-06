<?php

use App\Http\Livewire\Users;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[WelcomeController::class, 'index'])->middleware(\App\Http\Middleware\Authenticate::class);

Route::get('users', Users::class)->middleware(\App\Http\Middleware\Authenticate::class);

Route::get(
    '/prints/{id}',
    [\App\Http\Controllers\CarReceivePrintController::class, 'carReceive']
)->middleware(\App\Http\Middleware\Authenticate::class);

Route::get(
    '/car-release-prints/{id}',
    [\App\Http\Controllers\CarReleasePrintController::class, 'print']
)->middleware(\App\Http\Middleware\Authenticate::class);

Route::get(
    '/bill-prints/{id}',
    [\App\Http\Controllers\BillPrintController::class, 'print']
)->middleware(\App\Http\Middleware\Authenticate::class);

Route::get(
    '/cash-receipt-prints/{id}',
    [\App\Http\Controllers\CashReceiptPrintController::class, 'print']
)->middleware(\App\Http\Middleware\Authenticate::class);

Route::get(
    '/employee-requisition-prints/{id}',
    [\App\Http\Controllers\EmployeeRequisitionPrintController::class, 'print']
)->middleware(\App\Http\Middleware\Authenticate::class);

Route::get(
    '/invoice-prints/{id}',
    [\App\Http\Controllers\InvoicePrintController::class, 'print']
)->middleware(\App\Http\Middleware\Authenticate::class);

Route::get(
    '/price-control-bill-prints/{id}',
    [\App\Http\Controllers\PriceControlBillPrintController::class, 'print']
)->middleware(\App\Http\Middleware\Authenticate::class);

Route::get(
    '/purchase-order-prints/{id}',
    [\App\Http\Controllers\PurchaseOrderPrintController::class, 'print']
)->middleware(\App\Http\Middleware\Authenticate::class);

Route::get(
    '/quotation-prints/{id}',
    [\App\Http\Controllers\QuotationPrintController::class, 'print']
)->middleware(\App\Http\Middleware\Authenticate::class);

Route::get(
    '/requisition-prints/{id}',
    [\App\Http\Controllers\RequisitionPrintController::class, 'print']
)->middleware(\App\Http\Middleware\Authenticate::class);

Route::get(
    '/save-repair-cost-prints/{id}',
    [\App\Http\Controllers\SaveRepairCostPrintController::class, 'print']
)->middleware(\App\Http\Middleware\Authenticate::class);

