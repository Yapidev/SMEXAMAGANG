<?php

namespace App\Http\Controllers;

use App\Http\Requests\TempatPrakerin\StoreRequest;
use App\Http\Requests\TempatPrakerin\UpdateRequest;
use App\Models\TempatPrakerin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TempatPrakerinController extends Controller
{
    public function index()
    {
        $prakerin = TempatPrakerin::all();
        return view('tempatPrakerin.index', compact('prakerin'));
    }

    public function create()
    {
        return view('tempatPrakerin.create');
    }

    public function store(StoreRequest $request)
    {
        try {
            $validatedData = $request->validated();
            if ($request->hasFile('image')) {
                $validatedData['image'] = $request->image->store('uploads/tempatPrakerin/', 'public');
            }
            TempatPrakerin::create($validatedData);
            return redirect()->back()->with('messages', 'Berhasil Menambah Data')->withStatus(201);
        } catch (\Exception $e) {
            return redirect()->back()->with('messages', 'Gagal Menambah Data. ' . $e->getMessage())->withStatus(400);
        }
    }

    public function update(UpdateRequest $request, $id)
    {
        try {
            $tempatPrakerin = TempatPrakerin::findOrFail($id);
            $validatedUpdate = $request->validated();
            if ($request->hasFile('image')) {
                if ($tempatPrakerin->image) {
                    Storage::disk('public')->delete($tempatPrakerin->image);
                }
                $validatedUpdate['image'] = $request->file('image')->store('uploads/tempatPrakerin/', 'public');
            } else {
                $validatedUpdate['image'] = $tempatPrakerin->image;
            }
            $tempatPrakerin->update($validatedUpdate);
            return redirect()->back()->with('messages', 'Berhasil Memperbarui Data')->withStatus(200);
        } catch (\Exception $e) {
            return redirect()->back()->with('messages', 'Gagal Memperbarui Data. ' . $e->getMessage())->withStatus(400);
        }
    }

    public function destroy($id)
    {
        try {
            $prakerin = TempatPrakerin::findOrFail($id);
            $prakerin->delete($id);
            return redirect()->back()->with('messages', 'Berhasil Menghapus Data')->withStatus(202);
        } catch (\Exception $e) {
            return redirect()->back()->with('messages', 'Gagal Menghapus Data' . $e->getMessage())->withStatus(400);
        }
    }
}
