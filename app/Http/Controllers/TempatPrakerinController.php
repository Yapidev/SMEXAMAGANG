<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TempatPrakerinController extends Controller
{
    public function index() {
        return view('tempatPrakerin.index');
    }
}
