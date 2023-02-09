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
