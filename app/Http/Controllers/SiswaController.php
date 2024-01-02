<?php

namespace App\Http\Controllers;

use App\Http\Requests\Siswa\StoreRequest;
use App\Http\Requests\Siswa\UpdateRequest;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index() {
        return view('siswa.index');
    }

    public function create() {
        return view('siswa.create');
    }

    public function edit() {
        return view('siswa.edit');
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
