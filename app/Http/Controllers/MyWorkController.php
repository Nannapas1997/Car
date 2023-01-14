<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MyWorkController extends Controller
{
    function index() {
        view('mywork');
    }
}
