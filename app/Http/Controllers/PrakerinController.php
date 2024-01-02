<?php

namespace App\Http\Controllers;

use App\Http\Requests\Prakerin\StoreRequest;
use App\Http\Requests\Prakerin\UpdateRequest;
use Illuminate\Http\Request;

class PrakerinController extends Controller
{
    public function index() {
        return view('prakerin.index');
    }

    public function create() {
        return view('prakerin.create');
    }

    public function edit() {
        return view('prakerin.edit');
    }

    public function store(StoreRequest $request) {
        // 
    }

    public function update(UpdateRequest $request) {
        // 
    }

    public function destroy($id) {
        // 
    }
}
